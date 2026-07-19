<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\NilaiRapor;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\Semester;
use App\Models\Absensi;
use App\Models\Rapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalMapel = MataPelajaran::where('status', 'aktif')->count();

        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();

        $siswaPerKelas = Kelas::withCount('siswas')->get();

        $nilaiTertinggi = 0;
        $nilaiTerendah = 100;
        $rataNilaiPerKelas = [];
        $chartKelasLabels = [];
        $chartKelasSiswa = [];

        if ($tahunAktif && $semesterAktif) {
            $nilaiTertinggi = NilaiRapor::where('tahun_pelajaran_id', $tahunAktif->id)
                ->where('semester_id', $semesterAktif->id)
                ->max(DB::raw('(COALESCE(nilai_pengetahuan,0) + COALESCE(nilai_keterampilan,0)) / 2')) ?: 0;

            $nilaiTerendah = NilaiRapor::where('tahun_pelajaran_id', $tahunAktif->id)
                ->where('semester_id', $semesterAktif->id)
                ->min(DB::raw('(COALESCE(nilai_pengetahuan,0) + COALESCE(nilai_keterampilan,0)) / 2')) ?: 0;

            foreach ($siswaPerKelas as $kelas) {
                $rata = NilaiRapor::where('kelas_id', $kelas->id)
                    ->where('tahun_pelajaran_id', $tahunAktif->id)
                    ->where('semester_id', $semesterAktif->id)
                    ->avg(DB::raw('(COALESCE(nilai_pengetahuan,0) + COALESCE(nilai_keterampilan,0)) / 2'));
                $rataNilaiPerKelas[$kelas->nama_kelas] = round($rata ?: 0, 2);
            }

            $chartKelasLabels = $siswaPerKelas->pluck('nama_kelas')->toArray();
            $chartKelasSiswa = $siswaPerKelas->pluck('siswas_count')->toArray();
        }

        $recentRapors = Rapor::with(['siswa', 'kelas'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalKelas', 'totalMapel',
            'siswaPerKelas', 'nilaiTertinggi', 'nilaiTerendah', 'rataNilaiPerKelas',
            'chartKelasLabels', 'chartKelasSiswa', 'recentRapors',
            'tahunAktif', 'semesterAktif'
        ));
    }
}
