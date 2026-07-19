<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'user_id',
        'kelas_id',
        'nis',
        'nisn',
        'nama_siswa',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'telepon_orang_tua',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
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
