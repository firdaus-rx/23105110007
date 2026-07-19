<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::all();
        $siswaUsers = User::where('role', 'siswa')->get();
        $kelasCount = $kelas->count();

        $namaSiswa = [
            'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko',
            'Fitri', 'Gilang', 'Hana', 'Irfan', 'Julia',
            'Kevin', 'Lestari', 'Mega', 'Nanda', 'Oscar',
            'Putri', 'Qori', 'Raka', 'Sari', 'Teguh',
            'Umi', 'Vino', 'Wulan', 'Xavier', 'Yuni',
            'Zaki', 'Arif', 'Bella', 'Candra', 'Dian',
        ];

        foreach ($siswaUsers as $index => $user) {
            $kelasItem = $kelas[$index % $kelasCount];
            $nama = $namaSiswa[$index] ?? "Siswa" . ($index + 1);

            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $kelasItem->id,
                'nis' => '2024' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'nisn' => '00' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                'nama_siswa' => $nama,
                'tempat_lahir' => 'Pidie',
                'tanggal_lahir' => now()->subYears(7 + ($kelasItem->tingkat - 1))->subDays(rand(1, 365)),
                'jenis_kelamin' => $index % 2 == 0 ? 'L' : 'P',
                'agama' => 'Islam',
                'alamat' => 'Kecamatan ' . chr(65 + ($index % 10)) . ', Pidie',
                'nama_ayah' => 'Ayah ' . $nama,
                'nama_ibu' => 'Ibu ' . $nama,
                'telepon_orang_tua' => '0813' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
