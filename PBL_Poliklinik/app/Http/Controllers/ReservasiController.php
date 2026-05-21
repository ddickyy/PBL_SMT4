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
    // PAGE RESERVASI
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
                )->orderBy('tanggal');
            }
        ])
            ->where('aktif', 1)
            ->orderBy('jam_mulai')
            ->get();

        $dokterGroups = $jadwals->groupBy('id_dokter');

        return view(
            'pasien.reservasi',
            compact(
                'jadwals',
                'dokterGroups'
            )
        );
    }

    // STORE RESERVASI
    public function store(Request $request)
    {
        $validated = $request->validate([

            'id_jadwal' =>
            'required|exists:jadwal_dokter,id_jadwal',

            'tanggal_reservasi' =>
            'required|date|after_or_equal:today',

        ]);

        try {

            DB::beginTransaction();

            // CEK RESERVASI EXISTING
            $existingReservasi = Reservasi::where(
                'id_user',
                Auth::user()->id_user
            )
                ->whereDate(
                    'tanggal_reservasi',
                    $validated['tanggal_reservasi']
                )
                ->whereNotIn('status', [
                    'dibatalkan'
                ])
                ->exists();

            if ($existingReservasi) {

                DB::rollBack();

                return back()->withErrors([

                    'reservasi' =>
                    'Anda sudah memiliki reservasi pada tanggal tersebut.'

                ]);
            }

            // AMBIL JADWAL
            $jadwal = JadwalDokter::with([

                'dokter.user',

                'dokter.spesialisasi'

            ])->findOrFail(
                $validated['id_jadwal']
            );

            // CEK JADWAL AKTIF
            if (!$jadwal->aktif) {

                DB::rollBack();

                return back()->withErrors([

                    'jadwal' =>
                    'Jadwal dokter tidak aktif.'

                ]);
            }

            // CEK HARI
            $hariReservasi = strtolower(
                Carbon::parse(
                    $validated['tanggal_reservasi']
                )
                    ->locale('id')
                    ->dayName
            );

            $hariJadwal = strtolower(
                trim($jadwal->hari)
            );

            // dd($hariReservasi, $hariJadwal);
            if ($hariReservasi !== $hariJadwal) {

                DB::rollBack();

                return back()->withErrors([

                    'tanggal' =>
                    'Tanggal tidak sesuai dengan jadwal dokter.'

                ]);
            }

            // CEK / BUAT KUOTA
            $kuota = KuotaHarian::firstOrCreate(

                [
                    'id_jadwal' =>
                    $jadwal->id_jadwal,

                    'tanggal' =>
                    $validated['tanggal_reservasi'],
                ],

                [
                    'kuota_terisi' => 0,

                    'kuota_maksimal' => floor(

                        Carbon::parse(
                            $jadwal->jam_mulai
                        )->diffInMinutes(

                            Carbon::parse(
                                $jadwal->jam_selesai
                            )

                        ) / $jadwal->durasi_menit
                    ),
                ]
            );

            // CEK KUOTA
            if (
                $kuota->kuota_terisi >=
                $kuota->kuota_maksimal
            ) {

                DB::rollBack();

                return back()->withErrors([

                    'kuota' =>
                    'Kuota reservasi sudah penuh.'

                ]);
            }

            // NOMOR URUT
            $nomorUrut =
                $kuota->kuota_terisi + 1;

            // PREFIX
            $namaSpesialis = strtolower(
                optional(
                    $jadwal->dokter->spesialisasi
                )->nama_spesialisasi
            );

            $prefix = 'A';

            if (
                str_contains(
                    $namaSpesialis,
                    'umum'
                )
            ) {
                $prefix = 'U';
            } elseif (
                str_contains(
                    $namaSpesialis,
                    'gigi'
                )
            ) {
                $prefix = 'G';
            }

            // NOMOR ANTREAN
            $nomorAntrian =
                $prefix . '-' .
                str_pad(
                    $nomorUrut,
                    2,
                    '0',
                    STR_PAD_LEFT
                );

            // ESTIMASI JAM
            $estimasiJam = Carbon::parse(
                $jadwal->jam_mulai
            )
                ->addMinutes(

                    ($nomorUrut - 1)
                        *
                        $jadwal->durasi_menit

                );

            // SIMPAN RESERVASI
            $reservasi = Reservasi::create([

                'id_user' =>
                Auth::user()->id_user,

                'id_jadwal' =>
                $jadwal->id_jadwal,

                'tanggal_reservasi' =>
                $validated['tanggal_reservasi'],

                'nomor_antrian' =>
                $nomorAntrian,

                'estimasi_jam' =>
                $estimasiJam->format('H:i:s'),

                'status' =>
                'menunggu',
            ]);

            // UPDATE KUOTA
            $kuota->increment(
                'kuota_terisi'
            );

            DB::commit();

            return redirect()
                ->route(
                    'pasien.reservasi.show',
                    $reservasi->id_reservasi
                )
                ->with([

                    'success' =>
                    'Reservasi berhasil dibuat.'

                ]);
        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage());
        }
    }


    // RIWAYAT
    public function riwayat()
    {
        $reservasiAktif = Reservasi::with([

            'jadwal.dokter.user',

            'jadwal.dokter.spesialisasi'

        ])
            ->where(
                'id_user',
                Auth::user()->id_user
            )
            ->whereNotIn('status', [
                'selesai',
                'done'
            ])
            ->latest('tanggal_reservasi')
            ->get();

        $riwayatSelesai = Reservasi::with([

            'jadwal.dokter.user',

            'jadwal.dokter.spesialisasi'

        ])
            ->where(
                'id_user',
                Auth::user()->id_user
            )
            ->whereIn('status', [
                'selesai',
                'done'
            ])
            ->latest('tanggal_reservasi')
            ->paginate(6);

        return view(
            'pasien.riwayat',
            compact(
                'reservasiAktif',
                'riwayatSelesai'
            )
        );
    }

    // DETAIL RESERVASI
    public function show($id)
    {
        $reservasi = Reservasi::with([

            'jadwal.dokter.user',

            'jadwal.dokter.spesialisasi'

        ])
            ->where(
                'id_user',
                Auth::user()->id_user
            )
            ->findOrFail($id);

        return view(
            'pasien.buktiReservasi',
            compact('reservasi')
        );
    }

    // CANCEL RESERVASI
    public function cancel($id)
    {
        DB::beginTransaction();

        try {

            $reservasi = Reservasi::where(
                'id_user',
                Auth::user()->id_user
            )
                ->findOrFail($id);

            if (
                $reservasi->status === 'selesai'
            ) {

                return back()->withErrors([

                    'status' =>
                    'Reservasi yang sudah selesai tidak dapat dibatalkan.'

                ]);
            }

            if (
                $reservasi->status === 'dibatalkan'
            ) {

                return back()->withErrors([

                    'status' =>
                    'Reservasi sudah dibatalkan sebelumnya.'

                ]);
            }

            // UPDATE STATUS
            $reservasi->update([

                'status' =>
                'dibatalkan'

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

                'error' =>
                'Gagal membatalkan reservasi.'

            ]);
        }
    }

    // PAGE BUKTI
    public function bukti()
    {
        $reservasiId =
            session('reservasi_id');

        if (!$reservasiId) {

            return redirect()
                ->route(
                    'pasien.reservasi.index'
                );
        }

        $reservasi = Reservasi::with([

            'jadwal.dokter.user',

            'jadwal.dokter.spesialisasi'

        ])->find($reservasiId);

        return view(
            'pasien.buktiReservasi',
            compact('reservasi')
        );
    }
}
