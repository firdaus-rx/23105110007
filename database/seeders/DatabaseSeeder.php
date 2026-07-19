<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GuruSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            MataPelajaranSeeder::class,
            TahunPelajaranSeeder::class,
            SemesterSeeder::class,
            JadwalMengajarSeeder::class,
            NilaiRaporSeeder::class,
        ]);
    }
}
