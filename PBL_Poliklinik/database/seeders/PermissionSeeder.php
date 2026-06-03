<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // MASTER DATA
            [
                'nama_permission' => 'role',
                'deskripsi' => 'Akses menu role',
            ],

            [
                'nama_permission' => 'user',
                'deskripsi' => 'Akses menu user',
            ],

            // STATUS
            [
                'nama_permission' => 'jurusan',
                'deskripsi' => 'Akses menu jurusan',
            ],

            [
                'nama_permission' => 'prodi',
                'deskripsi' => 'Akses menu prodi',
            ],

            [
                'nama_permission' => 'keahlian',
                'deskripsi' => 'Akses menu keahlian',
            ],

            [
                'nama_permission' => 'jabatan_tendik',
                'deskripsi' => 'Akses menu jabatan tendik',
            ],

            // PENGELOLA
            [
                'nama_permission' => 'admin',
                'deskripsi' => 'Akses menu admin',
            ],

            [
                'nama_permission' => 'dokter',
                'deskripsi' => 'Akses menu dokter',
            ],

            // PASIEN
            [
                'nama_permission' => 'mahasiswa',
                'deskripsi' => 'Akses menu mahasiswa',
            ],

            [
                'nama_permission' => 'dosen',
                'deskripsi' => 'Akses menu dosen',
            ],

            [
                'nama_permission' => 'tendik',
                'deskripsi' => 'Akses menu tendik',
            ],

            // RESERVASI
            [
                'nama_permission' => 'jadwal_dokter',
                'deskripsi' => 'Akses menu jadwal dokter',
            ],

            [
                'nama_permission' => 'rekam_medis',
                'deskripsi' => 'Akses menu rekam medis',
            ],

            [
                'nama_permission' => 'riwayat_reservasi',
                'deskripsi' => 'Akses menu riwayat reservasi',
            ],

            [
                'nama_permission' => 'reservasi',
                'deskripsi' => 'Akses menu reservasi',
            ],

            [
                'nama_permission' => 'penilaian',
                'deskripsi' => 'Akses menu penilaian',
            ],
        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate(
                [
                    'nama_permission'
                        => $permission['nama_permission']
                ],
                $permission
            );
        }
    }
}