<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Guardian;
use App\Models\Siswa;

class SiswaGuardianSeeder extends Seeder
{
    public function run(): void
    {
        // Data Orang Tua
        $guardian = Guardian::create([
            'name' => 'Bapak Ahmad',
            'email' => 'ahmad.orangtua@siakad.test',
            'phone' => '081234567890',
        ]);

        // Data Anak / Siswa
        Siswa::create([
            'nama' => 'Ahmad Naufal',
            'nisn' => '1234567890',
            'tanggal_lahir' => '2014-07-20',
            'guardian_id' => $guardian->id,
        ]);

        Siswa::create([
            'nama' => 'Ahmad Nisa',
            'nisn' => '1234567891',
            'tanggal_lahir' => '2015-01-15',
            'guardian_id' => $guardian->id,
        ]);
    }
}

