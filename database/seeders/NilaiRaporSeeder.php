<?php

namespace Database\Seeders;

use App\Models\JadwalMengajar;
use App\Models\NilaiRapor;
use App\Models\Siswa;
use App\Services\NilaiService;
use Illuminate\Database\Seeder;

class NilaiRaporSeeder extends Seeder
{
    public function run(): void
    {
        $nilaiService = new NilaiService();
        $jadwals = JadwalMengajar::all();

        foreach ($jadwals as $jadwal) {
            $siswas = Siswa::where('kelas_id', $jadwal->kelas_id)->get();

            foreach ($siswas as $siswa) {
                $nilaiPengetahuan = rand(60, 100);
                $nilaiKeterampilan = rand(60, 100);
                $nilaiAkhir = $nilaiService->hitungNilaiAkhir($nilaiPengetahuan, $nilaiKeterampilan);
                $mapel = $jadwal->mataPelajaran;

                NilaiRapor::create([
                    'siswa_id' => $siswa->id,
                    'guru_id' => $jadwal->guru_id,
                    'kelas_id' => $jadwal->kelas_id,
                    'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                    'tahun_pelajaran_id' => $jadwal->tahun_pelajaran_id,
                    'semester_id' => $jadwal->semester_id,
                    'nilai_pengetahuan' => $nilaiPengetahuan,
                    'nilai_keterampilan' => $nilaiKeterampilan,
                    'nilai_sikap' => ['Baik', 'Sangat Baik', 'Cukup'][rand(0, 2)],
                    'predikat' => $nilaiService->hitungPredikat($nilaiAkhir),
                    'deskripsi' => $nilaiService->hitungDeskripsi($nilaiAkhir, $mapel->kkm, $mapel->nama_mapel),
                ]);
            }
        }
    }
}
