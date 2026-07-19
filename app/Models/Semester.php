<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [
        'nama_semester',
        'status_aktif',
    ];

    public function jadwalMengajar()
    {
        return $this->hasMany(JadwalMengajar::class);
    }

    public function nilaiRapor()
    {
        return $this->hasMany(NilaiRapor::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function rapor()
    {
        return $this->hasMany(Rapor::class);
    }
}
