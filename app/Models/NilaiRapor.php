<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiRapor extends Model
{
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'kelas_id',
        'mata_pelajaran_id',
        'tahun_pelajaran_id',
        'semester_id',
        'nilai_pengetahuan',
        'nilai_keterampilan',
        'nilai_sikap',
        'predikat',
        'deskripsi',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
