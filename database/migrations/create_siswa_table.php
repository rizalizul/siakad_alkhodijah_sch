<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nisn')->unique();
            $table->date('tanggal_lahir');
            $table->foreignId('guardian_id')->nullable()->constrained('guardians')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};

// Harusnya yg ini lengkapnya
// Schema::create('siswa', function (Blueprint $table) {
//     $table->id();
//     $table->string('nama');
//     $table->string('nisn')->nullable();
//     $table->string('nis')->nullable()->after('nisn');
//     $table->string('nama_panggilan')->nullable();
//     $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
//     $table->string('tempat_lahir');
//     $table->date('tanggal_lahir');
//     $table->string('agama');
//     $table->string('pendidikan_sebelumnya')->nullable();
//     $table->text('alamat_siswa')->nullable();
//     $table->string('no_wa_siswa')->nullable();

//     $table->string('nama_ayah');
//     $table->string('nama_ibu');
//     $table->string('pekerjaan_ayah');
//     $table->string('pekerjaan_ibu');
//     $table->string('no_wa_ortu');
//     $table->text('alamat_ortu')->nullable();
//     $table->string('kelurahan');
//     $table->string('kecamatan');
//     $table->string('kota');
//     $table->string('provinsi');
//     $table->string('nama_wali')->nullable();
//     $table->string('pekerjaan_wali')->nullable();
//     $table->text('alamat_wali')->nullable();

//     $table->string('kk')->nullable();
//     $table->string('ktp_ayah')->nullable();
//     $table->string('ktp_ibu')->nullable();
//     $table->string('akta')->nullable();
//     $table->string('kta')->nullable();
//     $table->string('foto')->nullable();

//     $table->unsignedBigInteger('guardian_id')->nullable();
//     $table->timestamps();
// });
