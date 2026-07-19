<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Semester;
use App\Models\TahunPelajaran;
use Illuminate\Database\Seeder;

class JadwalMengajarSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::all();
        $kelas = Kelas::all();
        $mapels = MataPelajaran::where('status', 'aktif')->get();
        $tahun = TahunPelajaran::where('status_aktif', true)->first();
        $semester = Semester::where('status_aktif', true)->first();

        if (!$tahun || !$semester) return;

        foreach ($kelas as $k) {
            foreach ($mapels as $index => $mapel) {
                $guru = $gurus[$index % $gurus->count()];
                JadwalMengajar::create([
                    'guru_id' => $guru->id,
                    'kelas_id' => $k->id,
                    'mata_pelajaran_id' => $mapel->id,
                    'tahun_pelajaran_id' => $tahun->id,
                    'semester_id' => $semester->id,
                ]);
            }
        }
    }
}
