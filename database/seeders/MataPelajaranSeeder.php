<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mataPelajaran = [
            // Kelompok Wajib
            ['nama_mapel' => 'Pendidikan Agama dan Budi Pekerti', 'kelompok' => 'Wajib'],
            ['nama_mapel' => 'Matematika', 'kelompok' => 'Wajib'],
            ['nama_mapel' => 'Bahasa Indonesia', 'kelompok' => 'Wajib'],
            ['nama_mapel' => 'Pendidikan Pancasila', 'kelompok' => 'Wajib'],
            ['nama_mapel' => 'PJOK', 'kelompok' => 'Wajib'],
            ['nama_mapel' => 'Bahasa Inggris', 'kelompok' => 'Wajib'],
            
            // Kelompok Seni Pilihan
            ['nama_mapel' => 'Seni Rupa', 'kelompok' => 'Seni Pilihan'],

            // Kelompok Muatan Lokal
            ['nama_mapel' => 'Bahasa Jawa', 'kelompok' => 'Muatan Lokal'],
        ];

        // Looping untuk memasukkan data ke database
        foreach ($mataPelajaran as $mapel) {
            MataPelajaran::create($mapel);
        }
    }
}
