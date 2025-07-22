<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Pramuka', 'Menggambar', 'Renang', 'Storytelling', 'Banjari'];
        foreach ($data as $nama) {
            \App\Models\Ekstrakurikuler::updateOrCreate(['nama' => $nama]);
        }
    }
}
