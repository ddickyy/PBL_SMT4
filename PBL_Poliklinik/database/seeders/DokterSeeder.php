<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        // ROLE DOKTER
        $roleDokter = DB::table('roles')
            ->where('nama_role', 'dokter')
            ->first();

        // SPESIALISASI
        $umum = DB::table('spesialisasi')
            ->where('nama_spesialisasi', 'Dokter Umum')
            ->first();

        $gigi = DB::table('spesialisasi')
            ->where('nama_spesialisasi', 'Dokter Gigi')
            ->first();

        // DATA USER DOKTER

        $userSatra = DB::table('users')->insertGetId([
            'id_role' => $roleDokter->id_role,
            'nama' => 'dr. Satra Wiyanto',
            'email' => 'satra@poliklinik.com',
            'password' => Hash::make('123456789'),
            'foto' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userBalqis = DB::table('users')->insertGetId([
            'id_role' => $roleDokter->id_role,
            'nama' => 'drg. Balqis',
            'email' => 'balqis@poliklinik.com',
            'password' => Hash::make('123456789'),
            'foto' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // DATA DOKTER
        $dokterSatra = DB::table('dokter')->insertGetId([
            'id_user' => $userSatra,
            'id_spesialisasi' => 1,
            'sip_dokter' => 'SIP-UMUM-001',
            'no_hp' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dokterBalqis = DB::table('dokter')->insertGetId([
            'id_user' => $userBalqis,
            'id_spesialisasi' => 2,
            'sip_dokter' => 'SIP-GIGI-001',
            'no_hp' => '081234567891',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //JADWAL DOKTER
        // dr. Satra Wiyanto - Jumat
        $jadwalSatra = DB::table('jadwal_dokter')->insertGetId([
            'id_dokter' => $dokterSatra,
            'hari' => 'Jumat',
            'jam_mulai' => '12:15:00',
            'jam_selesai' => '14:00:00',
            'durasi_menit' => 10,
            'aktif' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // drg. Balqis - Rabu
        $jadwalBalqisRabu = DB::table('jadwal_dokter')->insertGetId([
            'id_dokter' => $dokterBalqis,
            'hari' => 'Rabu',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '16:00:00',
            'durasi_menit' => 30,
            'aktif' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //KUOTA HARIAN
        DB::table('kuota_harian')->insert([
            [
                'id_jadwal' => $jadwalSatra,
                'tanggal' => now()->toDateString(),
                'kuota_terisi' => 0,
                'kuota_maksimal' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id_jadwal' => $jadwalBalqisRabu,
                'tanggal' => now()->toDateString(),
                'kuota_terisi' => 0,
                'kuota_maksimal' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
