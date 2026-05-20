<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\KuotaHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    // TAMPILKAN FORM RESERVASI
    public function index()
    {
        $jadwals = JadwalDokter::with([
            'dokter.user',
            'dokter.spesialisasi',
            'kuotaHarian' => function ($query) {
                $query->whereDate(
                    'tanggal',
                    '>=',
                    now('Asia/Jakarta')->toDateString()
                )
                ->orderBy('tanggal');
            }
        ])
        ->where('aktif', 1)
        ->orderBy('jam_mulai')
        ->get();

        $dokterGroups = $jadwals->groupBy('id_dokter');

        return view('pasien.reservasi', compact(
            'jadwals',
            'dokterGroups'
        ));
    }

    // PROSES RESERVASI
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jadwal' => 'required|exists:jadwal_dokter,id_jadwal',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
        ]);

        DB::beginTransaction();

        try {

            // CEK RESERVASI EXISTING
            $existingReservasi = Reservasi::where(
                'id_user',
                Auth::id()
            )
            ->where(
                'tanggal_reservasi',
                $validated['tanggal_reservasi']
            )
            ->whereNotIn('status', [
                'dibatalkan'
            ])
            ->exists();

            if ($existingReservasi) {

                return back()->withErrors([
                    'reservasi' => 'Anda sudah memiliki reservasi pada tanggal tersebut.'
                ]);
            }

            // CEK JADWAL DOKTER
            $jadwal = JadwalDokter::with([
                'dokter.user',
                'dokter.spesialisasi'
            ])->findOrFail(
                $validated['id_jadwal']
            );

            // CEK JADWAL AKTIF
            if (!$jadwal->aktif) {

                return back()->withErrors([
                    'jadwal' => 'Jadwal dokter tidak aktif.'
                ]);
            }

            /// CEK TANGGAL RESERVASI SESUAI JADWAL
            $kuota = KuotaHarian::where(
                'id_jadwal',
                $jadwal->id_jadwal
            )
            ->where(
                'tanggal',
                $validated['tanggal_reservasi']
            )
            ->first();

            // CEK KUOTA ADA
            if (!$kuota) {

                return back()->withErrors([
                    'kuota' => 'Kuota harian belum tersedia.'
                ]);
            }

            // CEK KUOTA PENUH
            if (
                $kuota->kuota_terisi >=
                $kuota->kuota_maksimal
            ) {

                return back()->withErrors([
                    'kuota' => 'Kuota reservasi sudah penuh.'
                ]);
            }

            /// HITUNG NOMOR ANTRIAN
            $nomorAntrian =
                $kuota->kuota_terisi + 1;

            /// ESTIMASI JAM
            $jamMulai = Carbon::parse(
                $jadwal->jam_mulai
            );

            $estimasiJam = $jamMulai
                ->copy()
                ->addMinutes(
                    ($nomorAntrian - 1)
                    * $jadwal->durasi_menit
                );

            // SIMPAN RESERVASI
            $reservasi = Reservasi::create([
                'id_user' => Auth::id(),
                'id_jadwal' => $jadwal->id_jadwal,
                'tanggal_reservasi' => $validated['tanggal_reservasi'],
                'nomor_antrian' => $nomorAntrian,
                'estimasi_jam' => $estimasiJam->format('H:i:s'),
                'status' => 'pending',
            ]);

            // UPDATE KUOTA
            $kuota->increment(
                'kuota_terisi'
            );

            DB::commit();

            return redirect()
                ->route('pasien.bukti')
                ->with([
                    'success' => 'Reservasi berhasil dibuat.',
                    'reservasi_id' => $reservasi->id_reservasi
                ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors([
                'error' => 'Reservasi gagal: ' . $e->getMessage()
            ]);
        }
    }

    /// RIWAYAT RESERVASI
    public function riwayat()
    {
        $reservasis = Reservasi::with([
            'jadwal.dokter.user',
            'jadwal.dokter.spesialisasi'
        ])
        ->where(
            'id_user',
            Auth::id()
        )
        ->latest('tanggal_reservasi')
        ->get();

        return view(
            'pasien.riwayat',
            compact('reservasis')
        );
    }

    /// DETAIL RESERVASI
    public function show($id)
    {
        $reservasi = Reservasi::with([
            'jadwal.dokter.user',
            'jadwal.dokter.spesialisasi'
        ])
        ->where(
            'id_user',
            Auth::id()
        )
        ->findOrFail($id);

        return view(
            'pasien.detailReservasi',
            compact('reservasi')
        );
    }

    /// BATAL RESERVASI
    public function cancel($id)
    {
        DB::beginTransaction();

        try {

            $reservasi = Reservasi::where(
                'id_user',
                Auth::id()
            )->findOrFail($id);

            // CEK STATUS
            if (
                $reservasi->status === 'selesai'
            ) {

                return back()->withErrors([
                    'status' => 'Reservasi yang sudah selesai tidak dapat dibatalkan.'
                ]);
            }

            if (
                $reservasi->status === 'dibatalkan'
            ) {

                return back()->withErrors([
                    'status' => 'Reservasi sudah dibatalkan sebelumnya.'
                ]);
            }

            // UPDATE STATUS
            $reservasi->update([
                'status' => 'dibatalkan'
            ]);

            // UPDATE KUOTA
            $kuota = KuotaHarian::where(
                'id_jadwal',
                $reservasi->id_jadwal
            )
            ->where(
                'tanggal',
                $reservasi->tanggal_reservasi
            )
            ->first();

            if (
                $kuota &&
                $kuota->kuota_terisi > 0
            ) {

                $kuota->decrement(
                    'kuota_terisi'
                );
            }

            DB::commit();

            return back()->with(
                'success',
                'Reservasi berhasil dibatalkan.'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors([
                'error' => 'Gagal membatalkan reservasi.'
            ]);
        }
    }

    public function bukti()
     {
         $reservasiId = session('reservasi_id');
    
         if (!$reservasiId) {
             return redirect()->route('pasien.reservasi');
         }
    
         $reservasi = Reservasi::with([
            'jadwal.dokter.user',
            'jadwal.dokter.spesialisasi'
        ])->find($reservasiId);
   
        return view('pasien.buktiReservasi', compact('reservasi'));
    }
    
}