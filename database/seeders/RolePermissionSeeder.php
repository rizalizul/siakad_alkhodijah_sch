<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = ['superadmin', 'staf_administrasi', 'bendahara', 'guru_mapel', 'wali_kelas', 'kepala_sekolah', 'wakasek_kurikulum', 'orangtua'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@siakad.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('superadmin');
    }
}
