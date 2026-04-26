<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpesialisasiSeeder extends Seeder
{
    public function run(): void
    {
        $spesialisasi = [
            ['nama_spesialisasi' => 'Dokter Umum', 'created_at' => now(), 'updated_at' => now()],
            ['nama_spesialisasi' => 'Dokter Gigi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_spesialisasi' => 'Psikolog', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('spesialisasi')->insert($spesialisasi);
    }
}