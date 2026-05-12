<?php

namespace App\Http\Controllers;

use App\Models\Dokter;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with([
            'user',
            'spesialisasi',
            'jadwalDokter'
        ])->get();

        return view('pasien.dokter', compact('dokters'));
    }
}