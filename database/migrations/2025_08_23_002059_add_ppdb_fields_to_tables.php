<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tahun_ajaran', function (Blueprint $table) {
            $table->boolean('is_ppdb_open')->default(false)->after('is_active');
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->string('no_pendaftaran')->unique()->nullable()->after('id');
            $table->string('tahun_ajaran_ppdb')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('tahun_ajaran', function (Blueprint $table) {
            $table->dropColumn('is_ppdb_open');
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('no_pendaftaran');
            $table->dropColumn('tahun_ajaran_ppdb');
        });
    }
};