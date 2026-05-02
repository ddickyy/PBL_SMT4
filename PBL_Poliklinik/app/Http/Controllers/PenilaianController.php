<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function create($reservasi)
    {
        $reservasi = Reservasi::with(['jadwal.dokter.user', 'jadwal.dokter.spesialisasi'])
            ->findOrFail($reservasi);

        return view('patient.penilaian.create', compact('reservasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_reservasi' => 'required|exists:reservasi,id_reservasi',
            'kritik' => 'nullable|string|max:1000',
            'saran' => 'nullable|string|max:1000',
        ]);

        Penilaian::create([
            'id_reservasi' => $request->id_reservasi,
            'kritik' => $request->kritik,
            'saran' => $request->saran,
        ]);

        return redirect()->route('pasien.beranda')->with('success', 'Terima kasih, penilaian berhasil dikirim.');
    }
}