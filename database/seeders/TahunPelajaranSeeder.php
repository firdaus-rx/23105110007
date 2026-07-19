<?php

namespace Database\Seeders;

use App\Models\TahunPelajaran;
use Illuminate\Database\Seeder;

class TahunPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        TahunPelajaran::create([
            'nama_tahun' => '2025/2026',
            'status_aktif' => true,
        ]);
    }
}
