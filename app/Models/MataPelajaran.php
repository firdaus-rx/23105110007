<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kkm',
        'kelompok',
        'status',
    ];

    public function jadwalMengajar()
    {
        return $this->hasMany(JadwalMengajar::class);
    }

    public function nilaiRapor()
    {
        return $this->hasMany(NilaiRapor::class);
    }
}
