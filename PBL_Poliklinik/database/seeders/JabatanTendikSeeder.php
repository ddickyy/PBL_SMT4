<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanTendikSeeder extends Seeder
{
    public function run(): void
    {
        $jabatan = [
            ['nama_jabatan' => 'Analisis Anggaran', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Analisis Kepegawaian', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Analisis Pengelolaan Keuangan APBN', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Arsiparis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Jabatan Fungsional Umum', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Pengembang Teknologi Pembelajaran', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Pranata Laboratorium Pendidikan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Pustakawan', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('jabatan_tendik')->insert($jabatan);
    }
}