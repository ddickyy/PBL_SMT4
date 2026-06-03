<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    // TAMPILKAN FORM PENILAIAN
    public function create($reservasi)
    {
        $reservasi = Reservasi::with([
            'jadwal.dokter.user',
            'jadwal.dokter.spesialisasi'
        ])
        ->where('id_user', Auth::id())
        ->findOrFail($reservasi);

        // HANYA RESERVASI SELESAI
        if ($reservasi->status !== 'selesai') {

            return redirect()
                ->route('pasien.riwayat')
                ->withErrors([
                    'penilaian' => 'Penilaian hanya dapat diberikan setelah reservasi selesai.'
                ]);
        }

        // CEK SUDAH ADA PENILAIAN
        $sudahMenilai = Penilaian::where(
            'id_reservasi',
            $reservasi->id_reservasi
        )->exists();

        if ($sudahMenilai) {

            return redirect()
                ->route('pasien.riwayat')
                ->withErrors([
                    'penilaian' => 'Reservasi ini sudah diberi penilaian.'
                ]);
        }

        return view('pasien.penilaian', compact('reservasi'));
    }

    // PROSES PENILAIAN
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_reservasi' => 'required|exists:reservasi,id_reservasi',
            'kritik' => 'nullable|string|max:1000',
            'saran' => 'nullable|string|max:1000',
        ]);

        // AMBIL RESERVASI MILIK USER
        $reservasi = Reservasi::where(
            'id_user',
            Auth::id()
        )->findOrFail(
            $validated['id_reservasi']
        );

        // CEK STATUS
        if ($reservasi->status !== 'selesai') {

            return back()->withErrors([
                'penilaian' => 'Reservasi belum selesai.'
            ]);
        }

        // CEK DUPLIKAT
        $sudahMenilai = Penilaian::where(
            'id_reservasi',
            $reservasi->id_reservasi
        )->exists();

        if ($sudahMenilai) {

            return back()->withErrors([
                'penilaian' => 'Anda sudah memberikan penilaian.'
            ]);
        }

        // SIMPAN
        Penilaian::create([
            'id_reservasi' => $reservasi->id_reservasi,
            'kritik' => $validated['kritik'],
            'saran' => $validated['saran'],
        ]);

        return redirect()
            ->route('pasien.reservasi.show', $reservasi->id_reservasi)
            ->with('success', 'Terima kasih, ulasan berhasil dikirim.');
    }

    // UPDATE PENILAIAN
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kritik' => 'nullable|string|max:1000',
            'saran' => 'nullable|string|max:1000',
        ]);

        $penilaian = Penilaian::whereHas('reservasi', function ($q) {
            $q->where('id_user', Auth::id());
        })->findOrFail($id);

        $penilaian->update([
            'kritik' => $validated['kritik'],
            'saran' => $validated['saran'],
        ]);

        return back()->with('success', 'Penilaian berhasil diperbarui.');
    }
}