<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\NilaiRapor;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();

        $jadwals = JadwalMengajar::with(['kelas', 'mataPelajaran', 'tahunPelajaran', 'semester'])
            ->where('guru_id', $guru->id)
            ->whereHas('tahunPelajaran', fn($q) => $q->where('status_aktif', true))
            ->whereHas('semester', fn($q) => $q->where('status_aktif', true))
            ->get();

        $totalKelas = $jadwals->pluck('kelas_id')->unique()->count();
        $totalMapel = $jadwals->pluck('mata_pelajaran_id')->unique()->count();
        $totalJadwal = $jadwals->count();

        $kelasIds = $jadwals->pluck('kelas_id')->unique();
        $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();
        $siswaLaki = Siswa::whereIn('kelas_id', $kelasIds)->where('jenis_kelamin', 'L')->count();
        $siswaPerempuan = Siswa::whereIn('kelas_id', $kelasIds)->where('jenis_kelamin', 'P')->count();

        $jadwalsGroup = $jadwals->groupBy(fn($j) => $j->kelas->nama_kelas);

        $chartLabels = [];
        $chartData = [];
        foreach ($jadwalsGroup as $kelas => $items) {
            $chartLabels[] = $kelas;
            $rataKelas = NilaiRapor::whereIn('mata_pelajaran_id', $items->pluck('mata_pelajaran_id'))
                ->where('kelas_id', $items->first()->kelas_id)
                ->where('tahun_pelajaran_id', $items->first()->tahun_pelajaran_id)
                ->where('semester_id', $items->first()->semester_id)
                ->avg(DB::raw('(COALESCE(nilai_pengetahuan,0) + COALESCE(nilai_keterampilan,0)) / 2'));
            $chartData[] = round($rataKelas ?: 0, 2);
        }

        return view('guru.dashboard', compact(
            'guru', 'jadwalsGroup', 'totalKelas', 'totalMapel',
            'totalJadwal', 'totalSiswa', 'siswaLaki', 'siswaPerempuan', 'chartLabels', 'chartData',
            'tahunAktif', 'semesterAktif'
        ));
    }

    public function jadwal(Request $request)
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();
        $allTahun = TahunPelajaran::orderBy('nama_tahun')->get();
        $allSemester = Semester::all();

        $tahunId = $request->tahun_pelajaran_id;
        $semesterId = $request->semester_id;

        $jadwals = JadwalMengajar::with(['kelas', 'mataPelajaran', 'tahunPelajaran', 'semester'])
            ->where('guru_id', $guru->id)
            ->when($tahunId, fn($q) => $q->where('tahun_pelajaran_id', $tahunId))
            ->when(!$tahunId && $tahunAktif, fn($q) => $q->where('tahun_pelajaran_id', $tahunAktif->id))
            ->when($semesterId, fn($q) => $q->where('semester_id', $semesterId))
            ->when(!$semesterId && $semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->latest()
            ->get()
            ->groupBy(fn($j) => $j->kelas->nama_kelas);

        return view('guru.jadwal', compact(
            'jadwals', 'tahunAktif', 'semesterAktif', 'allTahun', 'allSemester'
        ));
    }
}
