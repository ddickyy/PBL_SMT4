<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;

class BerandaController extends Controller
{
    public function index()
    {
        // ambil dokter + spesialisasi
        $dokter = Dokter::with('spesialisasi')->limit(3)->get();

        // ambil jadwal aktif
        $jadwal = JadwalDokter::with('dokter')
            ->where('aktif', true)
            ->limit(3)
            ->get();

        return view('patient.beranda', compact('dokter', 'jadwal'));
    }
}