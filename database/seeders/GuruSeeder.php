<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            [
                'nip' => '199703252023022003',
                'nama' => 'Nanda Fitriana, S.Pd.',
                'email' => 'nanda.fitriana@alkhodijah.sch',
                'role' => 'guru_mapel',
                'jenis_kelamin' => 'Perempuan'
            ],
            [
                'nip' => '199508172023012001',
                'nama' => 'Adella Nuraini, S.Pd.',
                'email' => 'adella.nuraini@alkhodijah.sch',
                'role' => 'guru_mapel',
                'jenis_kelamin' => 'Perempuan'
            ],
            [
                'nip' => '199605202023012002',
                'nama' => 'Ayu Putri Damai Hati, S.Pd.',
                'email' => 'ayu.putri@alkhodijah.sch',
                'role' => 'guru_mapel',
                'jenis_kelamin' => 'Perempuan'
            ],
            [
                'nip' => '199411102023021001',
                'nama' => 'Azmil Ulya, S.H.',
                'email' => 'azmil.ulya.guru@alkhodijah.sch',
                'role' => 'guru_mapel',
                'jenis_kelamin' => 'Laki-laki'
            ],
        ];

        // Proses data guru yang juga membuat user baru
        foreach ($gurus as $guruData) {
            // 1. Buat atau cari User terlebih dahulu
            $user = User::firstOrCreate(
                ['email' => $guruData['email']],
                [
                    'name' => $guruData['nama'],
                    'password' => Hash::make('12345678'),
                    'role' => $guruData['role']
                ]
            );

            // 2. Buat data Guru yang terhubung dengan User tersebut
            Guru::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $guruData['nip'],
                    'nama' => $user->name,
                    'email' => $user->email,
                    'jenis_kelamin' => $guruData['jenis_kelamin']
                ]
            );
        }
    }
}
