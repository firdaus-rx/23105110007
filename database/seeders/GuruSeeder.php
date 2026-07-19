<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruUsers = User::where('role', 'guru')->get();

        $guruData = [
            ['nama_guru' => 'Ahmad Fauzi, S.Pd.I', 'nip' => '197501012005011001', 'jenis_kelamin' => 'L', 'telepon' => '081234567891'],
            ['nama_guru' => 'Siti Nurhaliza, S.Pd', 'nip' => '197802032006042002', 'jenis_kelamin' => 'P', 'telepon' => '081234567892'],
            ['nama_guru' => 'Muhammad Rizki, S.Pd', 'nip' => '198005042007031003', 'jenis_kelamin' => 'L', 'telepon' => '081234567893'],
            ['nama_guru' => 'Fitriani, S.Ag', 'nip' => '198206052008012004', 'jenis_kelamin' => 'P', 'telepon' => '081234567894'],
            ['nama_guru' => 'Bambang Suprapto, S.Pd', 'nip' => '198408062009021005', 'jenis_kelamin' => 'L', 'telepon' => '081234567895'],
        ];

        foreach ($guruUsers as $index => $user) {
            if (isset($guruData[$index])) {
                Guru::create(array_merge($guruData[$index], ['user_id' => $user->id]));
            }
        }
    }
}
