<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Rizky Firdausi Nuzula, S.M.', 'email' => 'admin@alkhodijah.sch', 'role' => 'staf_administrasi'],
            ['name' => 'Azmil Ulya, S.H.', 'email' => 'bendahara@alkhodijah.sch', 'role' => 'bendahara'],
            ['name' => 'Maslakhatul Ummah, S.H.', 'email' => 'kurikulum@alkhodijah.sch', 'role' => 'wakasek_kurikulum'],
            ['name' => 'Afifatur Rosidah, S.Si., M.Sc.', 'email' => 'kepsek@alkhodijah.sch', 'role' => 'kepala_sekolah'],
        ];

        // Looping untuk membuat setiap user
        foreach ($users as $userData) {
            User::firstOrCreate([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('12345678'),
                'role' => $userData['role']
            ]);
        }
    }
}
