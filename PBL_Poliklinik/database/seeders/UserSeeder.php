<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = DB::table('users')->insertGetId([
            'id_role' => '1',
            'nama' => 'Super Admin 1',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $adminPoliId = DB::table('users')->insertGetId([
            'id_role' => '2',
            'nama' => 'Admin Poliklinik 1',
            'email' => 'adminpoli@gmail.com',
            'password' => bcrypt('12345'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $esatovinId = DB::table('users')->insertGetId([
            'id_role' => '4',
            'nama' => 'Esatovin Victoria',
            'email' => 'esatovin@gmail.com',
            'password' => bcrypt('12345'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dickyId = DB::table('users')->insertGetId([
            'id_role' => '4',
            'nama' => 'Dicky Darmawan',
            'email' => 'dicky@gmail.com',
            'password' => bcrypt('12345'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sheilandraId = DB::table('users')->insertGetId([
            'id_role' => '4',
            'nama' => 'Sheilandra Zarawiba',
            'email' => 'sheilandra@gmail.com',
            'password' => bcrypt('12345'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $raymonId = DB::table('users')->insertGetId([
            'id_role' => '4',
            'nama' => 'Raymon Devtant',
            'email' => 'raymon@gmail.com',
            'password' => bcrypt('12345'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Eagerly query a valid prodi, jurusan, and jabatan ID
        $prodiId = DB::table('prodi')->value('id_prodi') ?? 1;
        $jurusanId = DB::table('jurusan')->value('id_jurusan') ?? 1;
        $jabatanId = DB::table('jabatan_tendik')->value('id_jabatan') ?? 1;

        // Seed mahasiswa
        DB::table('mahasiswa')->insert([
            [
                'id_user' => $esatovinId,
                'id_prodi' => $prodiId,
                'nim' => '2241720001',
                'no_hp' => '081234567801',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => $dickyId,
                'id_prodi' => $prodiId,
                'nim' => '2241720002',
                'no_hp' => '081234567802',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed dosen
        DB::table('dosen')->insert([
            [
                'id_user' => $sheilandraId,
                'id_jurusan' => $jurusanId,
                'nidn' => '0012345601',
                'no_hp' => '081234567803',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed tendik
        DB::table('tendik')->insert([
            [
                'id_user' => $raymonId,
                'id_jabatan' => $jabatanId,
                'nip' => '199001012020011001',
                'no_hp' => '081234567804',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
