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
        Schema::table('siswa', function (Blueprint $table) {
        $table->string('nis')->unique()->nullable()->after('nisn');
        $table->string('nama_panggilan')->nullable();
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->string('tempat_lahir')->nullable();
        $table->string('agama')->nullable();
        $table->string('pendidikan_sebelumnya')->nullable();
        $table->text('alamat_siswa')->nullable();
        $table->string('no_wa_siswa')->nullable();

        $table->string('nama_ayah')->nullable();
        $table->string('nama_ibu')->nullable();
        $table->string('pekerjaan_ayah')->nullable();
        $table->string('pekerjaan_ibu')->nullable();
        $table->string('no_wa_ortu')->nullable();
        $table->text('alamat_ortu')->nullable();
        $table->string('kelurahan')->nullable();
        $table->string('kecamatan')->nullable();
        $table->string('kota')->nullable();
        $table->string('provinsi')->nullable();
        $table->string('nama_wali')->nullable();
        $table->string('pekerjaan_wali')->nullable();
        $table->text('alamat_wali')->nullable();

        $table->string('kk')->nullable();
        $table->string('ktp_ayah')->nullable();
        $table->string('ktp_ibu')->nullable();
        $table->string('akta')->nullable();
        $table->string('kta')->nullable();
        $table->string('foto')->nullable();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
