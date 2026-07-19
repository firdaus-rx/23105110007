<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\NilaiRapor;
use App\Models\Rapor;

class RaporController extends Controller
{
    public function cetak(Rapor $rapor)
    {
        $user = auth()->user();

        if ($user->role === 'siswa' || $user->role === 'orang_tua') {
            $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
            if (!$siswa || $rapor->siswa_id !== $siswa->id || $rapor->status_rapor !== 'final') {
                abort(403, 'Akses tidak diizinkan.');
            }
        }

        $rapor->load(['siswa', 'kelas.waliKelas', 'tahunPelajaran', 'semester']);

        $nilais = NilaiRapor::with('mataPelajaran')
            ->where('siswa_id', $rapor->siswa_id)
            ->where('kelas_id', $rapor->kelas_id)
            ->where('tahun_pelajaran_id', $rapor->tahun_pelajaran_id)
            ->where('semester_id', $rapor->semester_id)
            ->get();

        $absensi = Absensi::where('siswa_id', $rapor->siswa_id)
            ->where('kelas_id', $rapor->kelas_id)
            ->where('tahun_pelajaran_id', $rapor->tahun_pelajaran_id)
            ->where('semester_id', $rapor->semester_id)
            ->first();

        return view('rapor.cetak', compact('rapor', 'nilais', 'absensi'));
    }
}