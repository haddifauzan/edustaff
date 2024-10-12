<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_user')->insert([
            'nama_user' => 'Admin Master',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Hashing password for security
            'role' => 'Admin',
            'status_akun' => 'Aktif',
            'no_hp' => '081313264584',
            'foto_profil' => null,
            'last_login' => null,
            'id_pegawai' => null, // Karena ini admin, bukan pegawai
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
