<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusan = [
            ['nama_jurusan' => 'Teknik Mesin', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jurusan' => 'Teknik Elektro', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jurusan' => 'Teknik Kimia', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jurusan' => 'Teknik Sipil', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jurusan' => 'Akuntansi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jurusan' => 'Administrasi Niaga', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jurusan' => 'Teknologi Informasi', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('jurusan')->insert($jurusan);
    }
}