<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = JadwalDokter::with([
            'dokter.user',
            'dokter.spesialisasi',
            'kuotaHarian'
        ])
        ->where('aktif', 1)
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get();

        return view('pasien.jadwal', compact('jadwals'));
    }
}