<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Reservasi;

class DokterController extends Controller
{
    // PAGE PASIEN (USER)
    public function index()
    {
        $dokters = Dokter::with([
            'user',
            'spesialisasi',
            'jadwalDokter'
        ])->get();

        return view('pasien.dokter', compact('dokters'));
    }

    public function beranda()
    {
        $dokterLayout = true;

        return view(
            'dokter.berandaDokter',
            compact('dokterLayout')
        );
    }

    public function pasien()
    {
        $dokterLayout = true;

        $pasienList = Reservasi::with('user')
            ->latest()
            ->get();

        return view(
            'dokter.daftarPasien',
            compact('pasienList', 'dokterLayout')
        );
    }

    public function riwayat()
    {
        $dokterLayout = true;

        $riwayatList = Reservasi::with('user')
            ->latest()
            ->get();

        return view(
            'dokter.riwayatPasien',
            compact('riwayatList', 'dokterLayout')
        );
    }

    public function profil()
    {
        $dokterLayout = true;

        return view(
            'dokter.profil.tampilan',
            compact('dokterLayout')
        );
    }

    public function editProfil()
    {
        $dokterLayout = true;

        return view(
            'dokter.profil.edit',
            compact('dokterLayout')
        );
    }

    public function detailPasien($id)
    {
        $dokterLayout = true;

        $pasien = [
            'id' => $id,
            'nama' => 'Ariana Grande',
            'nim' => '12310102',
            'kategori' => 'Mahasiswa',
            'email' => 'ariana@gmail.com',
            'telepon' => '081234567890',
            'alamat' => 'Malang, Jawa Timur',
            'foto' => null,

            'status' => 'processing',
            'label_status' => 'PROSES',

            'riwayat_kunjungan' => 7,
            'no_antrean' => '03',

            'jam_reservasi' => '13:30',
            'tanggal_reservasi' => 'Jumat, 16 Mei 2026',

            'dokter' => 'dr. Satra Wiyanto',
            'spesialisasi' => 'Dokter Umum',

            'keluhan' => 'Batuk pilek disertai flu dan tenggorokan sakit selama 3 hari.',

            'diagnosa' => 'Infeksi saluran pernapasan ringan.',

            'catatan_dokter' => 'Perbanyak istirahat, minum air hangat, dan konsumsi obat sesuai aturan.',

            'rating' => 4.9,

            'kritik_saran' => 'Pelayanan dokter sangat baik dan ramah.',
        ];

        return view(
            'dokter.detailPasien',
            compact('pasien', 'dokterLayout')
        );
    }
}
