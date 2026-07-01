<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    public function run()
    {
        DB::table('paket')->insert([
            ['nama_paket' => 'Paket 10 Mbps', 'speed_download' => 10, 'speed_upload' => 5, 'harga' => 100000, 'created_at' => now()],
            ['nama_paket' => 'Paket 30 Mbps', 'speed_download' => 30, 'speed_upload' => 15, 'harga' => 150000, 'created_at' => now()],
            ['nama_paket' => 'Paket 50 Mbps', 'speed_download' => 50, 'speed_upload' => 25, 'harga' => 200000, 'created_at' => now()],
            ['nama_paket' => 'Paket 70 Mbps', 'speed_download' => 70, 'speed_upload' => 35, 'harga' => 250000, 'created_at' => now()],
        ]);
    }
}