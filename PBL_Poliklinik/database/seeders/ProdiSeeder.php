<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $prodi = [
            ['id_jurusan' => 1, 'nama_prodi' => 'D3 Teknik Mesin', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 1, 'nama_prodi' => 'D4 Teknik Mesin Produksi dan Perawatan', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 1, 'nama_prodi' => 'D4 Teknik Otomotif Elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 1, 'nama_prodi' => 'D3 Teknologi Pemeliharaan Pesawat Udara', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 1, 'nama_prodi' => 'S2 Rekayasa Teknologi Manufaktur', 'created_at' => now(), 'updated_at' => now()],

            ['id_jurusan' => 2, 'nama_prodi' => 'D3 Teknik Elektronika', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 2, 'nama_prodi' => 'D3 Teknik Listrik', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 2, 'nama_prodi' => 'D3 Teknik Telekomunikasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 2, 'nama_prodi' => 'D4 Jaringan Telekomunikasi Digital', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 2, 'nama_prodi' => 'D4 Sistem Kelistrikan', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 2, 'nama_prodi' => 'D4 Teknik Elektronika', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 2, 'nama_prodi' => 'S2 Teknik Elektro', 'created_at' => now(), 'updated_at' => now()],

            ['id_jurusan' => 3, 'nama_prodi' => 'D3 Teknik Kimia', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 3, 'nama_prodi' => 'D4 Teknik Kimia', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 3, 'nama_prodi' => 'S2 Optimasi Rekayasa Kimia', 'created_at' => now(), 'updated_at' => now()],

            ['id_jurusan' => 4, 'nama_prodi' => 'D3 Teknik Sipil', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 4, 'nama_prodi' => 'D3 Teknologi Konstruksi Jalan, Jembatan, dan Bangunan Air', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 4, 'nama_prodi' => 'D3 Teknologi Pertambangan', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 4, 'nama_prodi' => 'D4 Manajemen Rekayasa Konstruksi', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 4, 'nama_prodi' => 'D4 Teknologi Konstruksi Jalan dan Jembatan', 'created_at' => now(), 'updated_at' => now()],

            ['id_jurusan' => 5, 'nama_prodi' => 'D3 Akuntansi', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 5, 'nama_prodi' => 'D4 Akuntansi Manajemen', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 5, 'nama_prodi' => 'D4 Keuangan', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 5, 'nama_prodi' => 'S2 Sistem Informasi Akuntansi', 'created_at' => now(), 'updated_at' => now()],

            ['id_jurusan' => 6, 'nama_prodi' => 'D3 Administrasi Bisnis', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 6, 'nama_prodi' => 'D4 Bahasa Inggris Untuk Industri Pariwisata', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 6, 'nama_prodi' => 'D4 Bahasa Inggris Untuk Komunikasi Bisnis dan Profesional', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 6, 'nama_prodi' => 'D4 Manajemen Pemasaran', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 6, 'nama_prodi' => 'D4 Pengelolaan Arsip dan Rekaman Informasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 6, 'nama_prodi' => 'D4 Usaha Perjalanan Wisata', 'created_at' => now(), 'updated_at' => now()],

            ['id_jurusan' => 7, 'nama_prodi' => 'D2 Pengembangan Piranti Lunak Situs', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 7, 'nama_prodi' => 'D4 Teknik Informatika', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 7, 'nama_prodi' => 'D4 Sistem Informasi Bisnis', 'created_at' => now(), 'updated_at' => now()],
            ['id_jurusan' => 7, 'nama_prodi' => 'S2 Rekayasa Teknologi Informasi', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('prodi')->insert($prodi);
    }
}