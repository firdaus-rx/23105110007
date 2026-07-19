<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@min21.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guru 1',
            'email' => 'guru1@min21.sch.id',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Guru 2',
            'email' => 'guru2@min21.sch.id',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Guru 3',
            'email' => 'guru3@min21.sch.id',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Guru 4',
            'email' => 'guru4@min21.sch.id',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Guru 5',
            'email' => 'guru5@min21.sch.id',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        for ($i = 1; $i <= 30; $i++) {
            User::create([
                'name' => "Siswa $i",
                'email' => "siswa$i@min21.sch.id",
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
            ]);
        }
    }
}
