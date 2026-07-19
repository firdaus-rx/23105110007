<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::all();

        $kelasData = [
            ['nama_kelas' => 'I A', 'tingkat' => 1],
            ['nama_kelas' => 'I B', 'tingkat' => 1],
            ['nama_kelas' => 'II A', 'tingkat' => 2],
            ['nama_kelas' => 'II B', 'tingkat' => 2],
            ['nama_kelas' => 'III A', 'tingkat' => 3],
            ['nama_kelas' => 'IV A', 'tingkat' => 4],
            ['nama_kelas' => 'V A', 'tingkat' => 5],
            ['nama_kelas' => 'VI A', 'tingkat' => 6],
        ];

        foreach ($kelasData as $index => $data) {
            Kelas::create([
                'nama_kelas' => $data['nama_kelas'],
                'tingkat' => $data['tingkat'],
                'wali_kelas_id' => $gurus[$index % $gurus->count()]->id ?? null,
            ]);
        }
    }
}
