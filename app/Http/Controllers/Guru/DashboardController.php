<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\NilaiRapor;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();

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
            'totalJadwal', 'totalSiswa', 'chartLabels', 'chartData'
        ));
    }

    public function jadwal()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $jadwals = JadwalMengajar::with(['kelas', 'mataPelajaran', 'tahunPelajaran', 'semester'])
            ->where('guru_id', $guru->id)
            ->latest()
            ->get()
            ->groupBy(fn($j) => $j->kelas->nama_kelas);

        return view('guru.jadwal', compact('jadwals'));
    }
}
