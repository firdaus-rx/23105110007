<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajarans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alfa')->default(0);
            $table->timestamps();
            $table->unique(['siswa_id', 'tahun_pelajaran_id', 'semester_id'], 'absensi_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
