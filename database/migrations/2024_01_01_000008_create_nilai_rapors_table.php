<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_rapors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('guru_id')->constrained('gurus')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajarans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('nilai_pengetahuan')->nullable();
            $table->integer('nilai_keterampilan')->nullable();
            $table->string('nilai_sikap')->nullable();
            $table->string('predikat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->unique(['siswa_id', 'mata_pelajaran_id', 'tahun_pelajaran_id', 'semester_id'], 'nilai_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_rapors');
    }
};
