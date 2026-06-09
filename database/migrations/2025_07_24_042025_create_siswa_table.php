<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_panggilan')->nullable();
            $table->string('nisn')->unique()->nullable();
            $table->string('nis')->unique()->nullable();
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama')->nullable();
            $table->string('pendidikan_sebelumnya')->nullable();
            $table->text('alamat_siswa')->nullable();
            $table->string('no_wa_siswa')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('no_wa_ortu')->nullable();
            $table->text('alamat_ortu')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('kk')->nullable();
            $table->string('ktp_ayah')->nullable();
            $table->string('ktp_ibu')->nullable();
            $table->string('foto')->nullable();
            
            // Kolom tambahan dari migrasi lain digabungkan di sini
            $table->string('hasil_screening')->nullable();
            $table->string('akta_kelahiran')->nullable();
            $table->string('kia')->nullable();

            // Status enum yang sudah diperbarui
            $table->enum('status', [
                'calon', 
                'diverifikasi', 
                'menunggu_screening', 
                'aktif', 
                'lulus', 
                'pindah', 
                'tidak_diterima'
            ])->default('calon');

            $table->foreignId('guardian_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
