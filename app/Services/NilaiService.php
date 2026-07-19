<?php

namespace App\Services;

use App\Models\NilaiRapor;
use App\Models\Rapor;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class NilaiService
{
    public function hitungNilaiAkhir($nilaiPengetahuan, $nilaiKeterampilan): float
    {
        return round(($nilaiPengetahuan + $nilaiKeterampilan) / 2, 2);
    }

    public function hitungPredikat($nilaiAkhir): string
    {
        if ($nilaiAkhir >= 90 && $nilaiAkhir <= 100) return 'A';
        if ($nilaiAkhir >= 80) return 'B';
        if ($nilaiAkhir >= 70) return 'C';
        return 'D';
    }

    public function hitungDeskripsi($nilaiAkhir, $kkm, $namaMapel): string
    {
        if ($nilaiAkhir >= $kkm) {
            return "Siswa mampu menguasai materi {$namaMapel} dengan baik.";
        }
        return "Siswa perlu bimbingan lebih dalam memahami materi {$namaMapel}.";
    }

    public function hitungRataRataRapor($siswaId, $kelasId, $tahunPelajaranId, $semesterId): float
    {
        $rata = NilaiRapor::where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_pelajaran_id', $tahunPelajaranId)
            ->where('semester_id', $semesterId)
            ->get()
            ->map(function ($nilai) {
                return $this->hitungNilaiAkhir($nilai->nilai_pengetahuan, $nilai->nilai_keterampilan);
            })
            ->avg();

        return round($rata ?: 0, 2);
    }

    public function hitungTotalNilai($siswaId, $kelasId, $tahunPelajaranId, $semesterId): int
    {
        return (int) NilaiRapor::where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_pelajaran_id', $tahunPelajaranId)
            ->where('semester_id', $semesterId)
            ->get()
            ->sum(function ($nilai) {
                return $this->hitungNilaiAkhir($nilai->nilai_pengetahuan, $nilai->nilai_keterampilan);
            });
    }

    public function hitungPeringkat($kelasId, $tahunPelajaranId, $semesterId): void
    {
        $siswas = Siswa::where('kelas_id', $kelasId)->get();
        $data = [];

        foreach ($siswas as $siswa) {
            $rata = $this->hitungRataRataRapor($siswa->id, $kelasId, $tahunPelajaranId, $semesterId);
            $data[] = ['siswa_id' => $siswa->id, 'rata_rata' => $rata];
        }

        usort($data, fn($a, $b) => $b['rata_rata'] <=> $a['rata_rata']);

        foreach ($data as $index => $item) {
            Rapor::where('siswa_id', $item['siswa_id'])
                ->where('kelas_id', $kelasId)
                ->where('tahun_pelajaran_id', $tahunPelajaranId)
                ->where('semester_id', $semesterId)
                ->update(['peringkat' => $index + 1]);
        }
    }

    public function updateRaporSiswa($siswaId, $kelasId, $tahunPelajaranId, $semesterId): void
    {
        $rata = $this->hitungRataRataRapor($siswaId, $kelasId, $tahunPelajaranId, $semesterId);
        $total = $this->hitungTotalNilai($siswaId, $kelasId, $tahunPelajaranId, $semesterId);

        Rapor::updateOrCreate(
            [
                'siswa_id' => $siswaId,
                'kelas_id' => $kelasId,
                'tahun_pelajaran_id' => $tahunPelajaranId,
                'semester_id' => $semesterId,
            ],
            [
                'total_nilai' => $total,
                'rata_rata' => $rata,
            ]
        );
    }
}
