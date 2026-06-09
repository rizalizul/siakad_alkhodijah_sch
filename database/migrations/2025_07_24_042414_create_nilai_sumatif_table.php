<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_sumatif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_siswa_id')->constrained('kelas_siswa')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->integer('nilai_sts')->nullable();
            $table->integer('nilai_sas')->nullable();
            $table->timestamps();

            // Pastikan setiap siswa hanya punya satu record nilai sumatif per mapel per semester
            $table->unique(['kelas_siswa_id', 'mapel_id', 'tahun_ajaran_id'], 'nilai_sumatif_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_sumatif');
    }
};