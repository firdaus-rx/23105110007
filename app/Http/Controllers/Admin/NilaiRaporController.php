<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\NilaiRapor;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Services\NilaiService;
use Illuminate\Http\Request;

class NilaiRaporController extends Controller
{
    protected $nilaiService;

    public function __construct(NilaiService $nilaiService)
    {
        $this->nilaiService = $nilaiService;
    }

    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $mataPelajarans = MataPelajaran::all();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();

        $query = NilaiRapor::with(['siswa', 'guru', 'kelas', 'mataPelajaran', 'tahunPelajaran', 'semester']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
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

        $nilais = $query->latest()->get()->groupBy(function ($n) {
            return $n->kelas->nama_kelas;
        });

        return view('admin.nilai-rapor.index', compact(
            'nilais', 'kelasList', 'mataPelajarans', 'tahunPelajarans', 'semesters',
            'tahunAktif', 'semesterAktif'
        ));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::where('status', 'aktif')->get();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();
        return view('admin.nilai-rapor.create', compact(
            'kelas', 'gurus', 'mataPelajarans', 'tahunPelajarans', 'semesters',
            'tahunAktif', 'semesterAktif'
        ));
    }

    public function getSiswaByKelas(Kelas $kelas)
    {
        $siswas = Siswa::where('kelas_id', $kelas->id)->get(['id', 'nama_siswa', 'nis']);
        return response()->json($siswas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'nilai' => 'required|array',
            'nilai.*.nilai_pengetahuan' => 'nullable|integer|min:0|max:100',
            'nilai.*.nilai_keterampilan' => 'nullable|integer|min:0|max:100',
            'nilai.*.nilai_sikap' => 'nullable|string|max:50',
        ]);

        foreach ($request->nilai as $siswaId => $data) {
            $nilaiPengetahuan = $data['nilai_pengetahuan'] ?? null;
            $nilaiKeterampilan = $data['nilai_keterampilan'] ?? null;

            if ($nilaiPengetahuan !== null || $nilaiKeterampilan !== null) {
                $nilaiAkhir = $this->nilaiService->hitungNilaiAkhir(
                    $nilaiPengetahuan ?? 0,
                    $nilaiKeterampilan ?? 0
                );

                $mapel = MataPelajaran::find($request->mata_pelajaran_id);

                NilaiRapor::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'guru_id' => $request->guru_id,
                        'kelas_id' => $request->kelas_id,
                        'mata_pelajaran_id' => $request->mata_pelajaran_id,
                        'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
                        'semester_id' => $request->semester_id,
                    ],
                    [
                        'nilai_pengetahuan' => $nilaiPengetahuan,
                        'nilai_keterampilan' => $nilaiKeterampilan,
                        'nilai_sikap' => $data['nilai_sikap'] ?? null,
                        'predikat' => $this->nilaiService->hitungPredikat($nilaiAkhir),
                        'deskripsi' => $this->nilaiService->hitungDeskripsi($nilaiAkhir, $mapel->kkm, $mapel->nama_mapel),
                    ]
                );

                $this->nilaiService->updateRaporSiswa(
                    $siswaId, $request->kelas_id,
                    $request->tahun_pelajaran_id, $request->semester_id
                );
            }
        }

        return redirect()->route('nilai-rapor.index')->with('success', 'Nilai rapor berhasil ditambahkan.');
    }

    public function edit(NilaiRapor $nilaiRapor)
    {
        $nilaiRapor->load(['siswa', 'guru', 'kelas', 'mataPelajaran', 'tahunPelajaran', 'semester']);
        $kelas = Kelas::all();
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::where('status', 'aktif')->get();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();
        return view('admin.nilai-rapor.edit', compact(
            'nilaiRapor', 'kelas', 'gurus', 'mataPelajarans',
            'tahunPelajarans', 'semesters', 'tahunAktif', 'semesterAktif'
        ));
    }

    public function update(Request $request, NilaiRapor $nilaiRapor)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'nilai' => 'required|array',
            'nilai.*.nilai_pengetahuan' => 'nullable|integer|min:0|max:100',
            'nilai.*.nilai_keterampilan' => 'nullable|integer|min:0|max:100',
            'nilai.*.nilai_sikap' => 'nullable|string|max:50',
        ]);

        foreach ($request->nilai as $siswaId => $data) {
            $nilaiPengetahuan = $data['nilai_pengetahuan'] ?? null;
            $nilaiKeterampilan = $data['nilai_keterampilan'] ?? null;

            if ($nilaiPengetahuan !== null || $nilaiKeterampilan !== null) {
                $nilaiAkhir = $this->nilaiService->hitungNilaiAkhir(
                    $nilaiPengetahuan ?? 0,
                    $nilaiKeterampilan ?? 0
                );

                $mapel = MataPelajaran::find($request->mata_pelajaran_id);

                NilaiRapor::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'guru_id' => $request->guru_id,
                        'kelas_id' => $request->kelas_id,
                        'mata_pelajaran_id' => $request->mata_pelajaran_id,
                        'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
                        'semester_id' => $request->semester_id,
                    ],
                    [
                        'nilai_pengetahuan' => $nilaiPengetahuan,
                        'nilai_keterampilan' => $nilaiKeterampilan,
                        'nilai_sikap' => $data['nilai_sikap'] ?? null,
                        'predikat' => $this->nilaiService->hitungPredikat($nilaiAkhir),
                        'deskripsi' => $this->nilaiService->hitungDeskripsi($nilaiAkhir, $mapel->kkm, $mapel->nama_mapel),
                    ]
                );

                $this->nilaiService->updateRaporSiswa(
                    $siswaId, $request->kelas_id,
                    $request->tahun_pelajaran_id, $request->semester_id
                );
            }
        }

        return redirect()->route('nilai-rapor.index')->with('success', 'Nilai rapor berhasil diperbarui.');
    }

    public function destroy(NilaiRapor $nilaiRapor)
    {
        $nilaiRapor->delete();
        return redirect()->route('nilai-rapor.index')->with('success', 'Nilai rapor berhasil dihapus.');
    }
}
