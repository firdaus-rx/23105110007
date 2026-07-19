<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            ['kode_mapel' => 'PAI', 'nama_mapel' => 'Pendidikan Agama Islam', 'kkm' => 75, 'kelompok' => 'A'],
            ['kode_mapel' => 'BIN', 'nama_mapel' => 'Bahasa Indonesia', 'kkm' => 75, 'kelompok' => 'A'],
            ['kode_mapel' => 'MTK', 'nama_mapel' => 'Matematika', 'kkm' => 75, 'kelompok' => 'A'],
            ['kode_mapel' => 'IPA', 'nama_mapel' => 'Ilmu Pengetahuan Alam', 'kkm' => 75, 'kelompok' => 'A'],
            ['kode_mapel' => 'IPS', 'nama_mapel' => 'Ilmu Pengetahuan Sosial', 'kkm' => 75, 'kelompok' => 'A'],
            ['kode_mapel' => 'PPKN', 'nama_mapel' => 'PPKn', 'kkm' => 75, 'kelompok' => 'A'],
            ['kode_mapel' => 'PJOK', 'nama_mapel' => 'PJOK', 'kkm' => 75, 'kelompok' => 'B'],
            ['kode_mapel' => 'SBDP', 'nama_mapel' => 'SBdP', 'kkm' => 75, 'kelompok' => 'B'],
            ['kode_mapel' => 'BAR', 'nama_mapel' => 'Bahasa Arab', 'kkm' => 75, 'kelompok' => 'A'],
        ];

        foreach ($mapel as $m) {
            MataPelajaran::create($m);
        }
    }
}
