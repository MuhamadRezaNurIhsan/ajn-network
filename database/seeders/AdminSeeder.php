<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Administrator (full akses) - update jika sudah ada
        DB::table('admin')->updateOrInsert(
            ['username' => 'admin'],
            [
                'password' => Hash::make('admin123'),
                'role' => 'administrator',
                'nama_lengkap' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Direktur (limited akses) - update jika sudah ada
        DB::table('admin')->updateOrInsert(
            ['username' => 'direktur'],
            [
                'password' => Hash::make('direktur123'),
                'role' => 'direktur',
                'nama_lengkap' => 'Direktur Utama',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}