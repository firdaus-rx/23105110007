<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajarans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('total_nilai')->default(0);
            $table->decimal('rata_rata', 5, 2)->default(0);
            $table->integer('peringkat')->nullable();
            $table->text('catatan_wali_kelas')->nullable();
            $table->enum('status_rapor', ['draft', 'final'])->default('draft');
            $table->date('tanggal_rapor')->nullable();
            $table->timestamps();
            $table->unique(['siswa_id', 'kelas_id', 'tahun_pelajaran_id', 'semester_id'], 'rapor_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapors');
    }
};
