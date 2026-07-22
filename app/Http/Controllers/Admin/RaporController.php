<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Rapor;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Services\NilaiService;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    protected $nilaiService;

    public function __construct(NilaiService $nilaiService)
    {
        $this->nilaiService = $nilaiService;
    }

    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();

        $query = Rapor::with(['siswa', 'kelas', 'tahunPelajaran', 'semester']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('tahun_pelajaran_id')) {
            $query->where('tahun_pelajaran_id', $request->tahun_pelajaran_id);
        } elseif ($tahunAktif) {
            $query->where('tahun_pelajaran_id', $tahunAktif->id);
        }
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        } elseif ($semesterAktif) {
            $query->where('semester_id', $semesterAktif->id);
        }

        $rapors = $query->latest()->get()->groupBy(function ($r) {
            return $r->kelas->nama_kelas;
        });

        return view('admin.rapor.index', compact(
            'rapors', 'kelasList', 'tahunPelajarans', 'semesters',
            'tahunAktif', 'semesterAktif'
        ));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();
        return view('admin.rapor.create', compact(
            'kelas', 'tahunPelajarans', 'semesters', 'tahunAktif', 'semesterAktif'
        ));
    }

    public function getSiswaByKelas(Kelas $kelas, Request $request)
    {
        $tahunPelajaranId = $request->tahun_pelajaran_id;
        $semesterId = $request->semester_id;

        $existingSiswaIds = Rapor::where('kelas_id', $kelas->id)
            ->when($tahunPelajaranId, fn($q) => $q->where('tahun_pelajaran_id', $tahunPelajaranId))
            ->when($semesterId, fn($q) => $q->where('semester_id', $semesterId))
            ->pluck('siswa_id');

        $siswas = Siswa::where('kelas_id', $kelas->id)
            ->whereNotIn('id', $existingSiswaIds)
            ->get(['id', 'nama_siswa', 'nis']);

        return response()->json($siswas);
    }

    public function getRaporData(Siswa $siswa, Request $request)
    {
        $tahunPelajaranId = $request->tahun_pelajaran_id;
        $semesterId = $request->semester_id;

        $rata = $this->nilaiService->hitungRataRataRapor(
            $siswa->id, $siswa->kelas_id, $tahunPelajaranId, $semesterId
        );
        $total = $this->nilaiService->hitungTotalNilai(
            $siswa->id, $siswa->kelas_id, $tahunPelajaranId, $semesterId
        );

        $existing = Rapor::where([
            'siswa_id' => $siswa->id,
            'kelas_id' => $siswa->kelas_id,
            'tahun_pelajaran_id' => $tahunPelajaranId,
            'semester_id' => $semesterId,
        ])->first();

        return response()->json([
            'rata_rata' => $rata,
            'total_nilai' => $total,
            'exists' => $existing ? true : false,
            'existing_id' => $existing?->id,
            'status' => $existing?->status_rapor ?? 'draft',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'catatan_wali_kelas' => 'nullable|string',
            'tanggal_rapor' => 'nullable|date',
        ]);

        $this->nilaiService->updateRaporSiswa(
            $request->siswa_id, $request->kelas_id,
            $request->tahun_pelajaran_id, $request->semester_id
        );

        Rapor::where([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'semester_id' => $request->semester_id,
        ])->update([
            'catatan_wali_kelas' => $request->catatan_wali_kelas,
            'tanggal_rapor' => $request->tanggal_rapor ?? now(),
        ]);

        $this->nilaiService->hitungPeringkat($request->kelas_id, $request->tahun_pelajaran_id, $request->semester_id);

        return redirect()->route('rapor.index')->with('success', 'Rapor berhasil disimpan.');
    }

    public function show(Rapor $rapor)
    {
        $rapor->load(['siswa.kelas', 'kelas.waliKelas', 'tahunPelajaran', 'semester']);

        $nilais = \App\Models\NilaiRapor::with('mataPelajaran')
            ->where('siswa_id', $rapor->siswa_id)
            ->where('kelas_id', $rapor->kelas_id)
            ->where('tahun_pelajaran_id', $rapor->tahun_pelajaran_id)
            ->where('semester_id', $rapor->semester_id)
            ->get();

        $absensi = \App\Models\Absensi::where('siswa_id', $rapor->siswa_id)
            ->where('kelas_id', $rapor->kelas_id)
            ->where('tahun_pelajaran_id', $rapor->tahun_pelajaran_id)
            ->where('semester_id', $rapor->semester_id)
            ->first();

        return view('admin.rapor.show', compact('rapor', 'nilais', 'absensi'));
    }

    public function edit(Rapor $rapor)
    {
        $rapor->load(['siswa', 'kelas', 'tahunPelajaran', 'semester']);
        $kelas = Kelas::all();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();
        return view('admin.rapor.edit', compact(
            'rapor', 'kelas', 'tahunPelajarans', 'semesters', 'tahunAktif', 'semesterAktif'
        ));
    }

    public function update(Request $request, Rapor $rapor)
    {
        $validated = $request->validate([
            'catatan_wali_kelas' => 'nullable|string',
            'status_rapor' => 'nullable|in:draft,final',
            'tanggal_rapor' => 'nullable|date',
        ]);

        $rapor->update($validated);
        return redirect()->route('rapor.index')->with('success', 'Rapor berhasil diperbarui.');
    }

    public function finalisasi(Rapor $rapor)
    {
        $this->nilaiService->hitungPeringkat(
            $rapor->kelas_id,
            $rapor->tahun_pelajaran_id,
            $rapor->semester_id
        );

        $rapor->update([
            'status_rapor' => 'final',
            'tanggal_rapor' => now(),
        ]);

        return redirect()->route('rapor.index')->with('success', 'Rapor berhasil difinalisasi.');
    }

    public function sinkronRanking(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tahunPelajaranId = $request->tahun_pelajaran_id;
        $semesterId = $request->semester_id;

        if (!$kelasId || !$tahunPelajaranId || !$semesterId) {
            return back()->with('error', 'Pilih kelas, tahun pelajaran, dan semester terlebih dahulu.');
        }

        $siswas = Siswa::where('kelas_id', $kelasId)->get();

        foreach ($siswas as $siswa) {
            $this->nilaiService->updateRaporSiswa(
                $siswa->id, $kelasId, $tahunPelajaranId, $semesterId
            );
        }

        $this->nilaiService->hitungPeringkat($kelasId, $tahunPelajaranId, $semesterId);

        $kelas = Kelas::find($kelasId);
        return redirect()->route('rapor.index', [
            'kelas_id' => $kelasId,
            'tahun_pelajaran_id' => $tahunPelajaranId,
            'semester_id' => $semesterId,
        ])->with('success', "Ranking Kelas {$kelas?->nama_kelas} berhasil disinkronkan.");
    }

    public function destroy(Rapor $rapor)
    {
        $rapor->delete();
        return redirect()->route('rapor.index')->with('success', 'Rapor berhasil dihapus.');
    }

    public function cetakRapor(Rapor $rapor)
    {
        $rapor->load(['siswa', 'kelas.waliKelas', 'tahunPelajaran', 'semester']);

        $nilais = \App\Models\NilaiRapor::with('mataPelajaran')
            ->where('siswa_id', $rapor->siswa_id)
            ->where('kelas_id', $rapor->kelas_id)
            ->where('tahun_pelajaran_id', $rapor->tahun_pelajaran_id)
            ->where('semester_id', $rapor->semester_id)
            ->get();

        $absensi = \App\Models\Absensi::where('siswa_id', $rapor->siswa_id)
            ->where('kelas_id', $rapor->kelas_id)
            ->where('tahun_pelajaran_id', $rapor->tahun_pelajaran_id)
            ->where('semester_id', $rapor->semester_id)
            ->first();

        return view('rapor.cetak', compact('rapor', 'nilais', 'absensi'));
    }
}