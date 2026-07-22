<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\NilaiRapor;
use App\Models\Rapor;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Services\NilaiService;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    protected $nilaiService;

    public function __construct(NilaiService $nilaiService)
    {
        $this->nilaiService = $nilaiService;
    }

    public function index()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $kelasList = Kelas::with('waliKelas')->where('wali_kelas_id', $guru->id)->get();

        if ($kelasList->isEmpty()) {
            return view('guru.wali.index')->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }

        $siswaPerKelas = [];
        foreach ($kelasList as $kelas) {
            $siswaPerKelas[$kelas->id] = Siswa::where('kelas_id', $kelas->id)->get();
        }

        return view('guru.wali.index', compact('kelasList', 'siswaPerKelas'));
    }

    public function absensi(Request $request)
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $kelasList = Kelas::where('wali_kelas_id', $guru->id)->get();

        if ($kelasList->isEmpty()) {
            return back()->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }

        $kelasId = $request->kelas_id ?? $kelasList->first()->id;
        $kelas = $kelasList->firstWhere('id', $kelasId) ?? $kelasList->first();

        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();
        $siswas = Siswa::where('kelas_id', $kelas->id)->get();

        $absensis = Absensi::where('kelas_id', $kelas->id)
            ->where('tahun_pelajaran_id', $tahunAktif?->id)
            ->where('semester_id', $semesterAktif?->id)
            ->get()
            ->keyBy('siswa_id');

        return view('guru.wali.absensi', compact('kelasList', 'kelas', 'siswas', 'absensis', 'tahunAktif', 'semesterAktif'));
    }

    public function storeAbsensi(Request $request)
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->findOrFail($request->kelas_id);
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->firstOrFail();
        $semesterAktif = Semester::where('status_aktif', true)->firstOrFail();

        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'absensi' => 'required|array',
            'absensi.*.sakit' => 'nullable|integer|min:0',
            'absensi.*.izin' => 'nullable|integer|min:0',
            'absensi.*.alfa' => 'nullable|integer|min:0',
        ]);

        foreach ($request->absensi as $siswaId => $data) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'kelas_id' => $kelas->id,
                    'tahun_pelajaran_id' => $tahunAktif->id,
                    'semester_id' => $semesterAktif->id,
                ],
                [
                    'sakit' => $data['sakit'] ?? 0,
                    'izin' => $data['izin'] ?? 0,
                    'alfa' => $data['alfa'] ?? 0,
                ]
            );
        }

        return redirect()->route('guru.wali.absensi', ['kelas_id' => $kelas->id])->with('success', 'Absensi berhasil disimpan.');
    }

    public function rapor(Request $request)
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $kelasList = Kelas::where('wali_kelas_id', $guru->id)->get();

        if ($kelasList->isEmpty()) {
            return back()->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }

        $kelasId = $request->kelas_id ?? $kelasList->first()->id;
        $kelas = $kelasList->firstWhere('id', $kelasId) ?? $kelasList->first();

        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();

        $rapors = Rapor::with('siswa')
            ->where('kelas_id', $kelas->id)
            ->where('tahun_pelajaran_id', $tahunAktif?->id)
            ->where('semester_id', $semesterAktif?->id)
            ->get();

        return view('guru.wali.rapor', compact('kelasList', 'kelas', 'rapors', 'tahunAktif', 'semesterAktif'));
    }

    public function updateRapor(Request $request, Rapor $rapor)
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $kelasIds = Kelas::where('wali_kelas_id', $guru->id)->pluck('id');

        if (!$kelasIds->contains($rapor->kelas_id)) {
            abort(403);
        }

        $validated = $request->validate([
            'catatan_wali_kelas' => 'nullable|string',
        ]);

        $rapor->update($validated);
        return redirect()->route('guru.wali.rapor', ['kelas_id' => $rapor->kelas_id])->with('success', 'Catatan wali kelas berhasil disimpan.');
    }

    public function finalisasi(Rapor $rapor)
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $kelasIds = Kelas::where('wali_kelas_id', $guru->id)->pluck('id');

        if (!$kelasIds->contains($rapor->kelas_id)) {
            abort(403);
        }

        $this->nilaiService->hitungPeringkat(
            $rapor->kelas_id,
            $rapor->tahun_pelajaran_id,
            $rapor->semester_id
        );

        $rapor->update([
            'status_rapor' => 'final',
            'tanggal_rapor' => now(),
        ]);

        return redirect()->route('guru.wali.rapor', ['kelas_id' => $rapor->kelas_id])->with('success', 'Rapor berhasil difinalisasi.');
    }
}
