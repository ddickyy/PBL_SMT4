<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nama_role'  => 'superadmin',
                'deskripsi'  => 'Super administrator sistem dengan akses tertinggi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role'  => 'admin',
                'deskripsi'  => 'Administrator sistem dengan akses penuh untuk mengelola data dan pengguna',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role'  => 'dokter',
                'deskripsi'  => 'Dokter yang melayani pasien di poliklinik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role'  => 'pasien',
                'deskripsi'  => 'Pengguna sistem dengan akses terbatas untuk melihat informasi dan melakukan pendaftaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}