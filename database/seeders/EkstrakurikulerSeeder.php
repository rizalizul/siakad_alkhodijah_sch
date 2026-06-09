<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ekstrakurikuler; // Pastikan model Anda di-import

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ekstrakurikuler = [
            ['nama_ekskul' => 'Pramuka'],
            ['nama_ekskul' => 'Menggambar'],
            ['nama_ekskul' => 'Renang'],
            ['nama_ekskul' => 'Storytelling'],
            ['nama_ekskul' => 'Banjari'],
        ];

        // Looping untuk memasukkan data ke database
        foreach ($ekstrakurikuler as $ekskul) {
            Ekstrakurikuler::create($ekskul);
        }
    }
}