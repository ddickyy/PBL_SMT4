<?php

namespace App\Http\Controllers;

use App\Models\Dokter;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = Dokter::with([
            'user',
            'spesialisasi',
            'jadwal'
        ])->get();

        return view('patient.dokter.index', compact('dokter'));
    }
}