<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MataPelajaranSeeder::class,
            EkstrakurikulerSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            // Anda bisa menambahkan seeder lain di sini
        ]);
    }
}
