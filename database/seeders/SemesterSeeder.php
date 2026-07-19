<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        Semester::create([
            'nama_semester' => 'Ganjil',
            'status_aktif' => true,
        ]);

        Semester::create([
            'nama_semester' => 'Genap',
            'status_aktif' => false,
        ]);
    }
}
