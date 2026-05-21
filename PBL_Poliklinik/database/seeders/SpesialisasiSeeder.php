<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpesialisasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('spesialisasi')->insert([
            [
                'nama_spesialisasi' => 'Umum',
                'deskripsi' => 'Pelayanan pemeriksaan kesehatan umum dan konsultasi dasar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_spesialisasi' => 'Gigi',
                'deskripsi' => 'Pelayanan kesehatan dan perawatan gigi serta mulut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}