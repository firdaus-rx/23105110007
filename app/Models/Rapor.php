<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_pelajaran_id',
        'semester_id',
        'total_nilai',
        'rata_rata',
        'peringkat',
        'catatan_wali_kelas',
        'status_rapor',
        'tanggal_rapor',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
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
