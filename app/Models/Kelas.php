<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'wali_kelas_id',
    ];

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function jadwalMengajar()
    {
        return $this->hasMany(JadwalMengajar::class);
    }

    public function nilaiRapor()
    {
        return $this->hasMany(NilaiRapor::class);
    }

    public function rapor()
    {
        return $this->hasMany(Rapor::class);
    }
}
