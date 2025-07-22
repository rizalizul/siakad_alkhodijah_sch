<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'PABP', 'nama' => 'Pendidikan Agama dan Budi Pekerti'],
            ['kode' => 'PPKN', 'nama' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['kode' => 'BINDO', 'nama' => 'Bahasa Indonesia'],
            ['kode' => 'MTK', 'nama' => 'Matematika'],
            ['kode' => 'SENIRUPA', 'nama' => 'Seni Rupa'],
            ['kode' => 'PJOK', 'nama' => 'Pendidikan Jasmani, Olahraga dan Kesehatan'],
            ['kode' => 'BING', 'nama' => 'Bahasa Inggris'],
            ['kode' => 'BJAWA', 'nama' => 'Bahasa Jawa'],
        ];

        foreach ($data as $mapel) {
            MataPelajaran::updateOrCreate(['kode' => $mapel['kode']], $mapel);
        }
    }
}
