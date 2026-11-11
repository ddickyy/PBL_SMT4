<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanTendikSeeder extends Seeder
{
    public function run(): void
    {
        $jabatan = [
            ['nama_jabatan' => 'Kepala', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Staff', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('jabatan_tendik')->insert($jabatan);
    }
}