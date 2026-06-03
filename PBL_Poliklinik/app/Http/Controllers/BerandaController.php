<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use Carbon\Carbon;

class BerandaController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with([
            'user',
            'spesialisasi',
            'jadwalDokter'
        ])->get();

        $spesialisasiGroups = $dokters->groupBy(function ($dokter) {
            return optional($dokter->spesialisasi)->nama_spesialisasi ?? 'Lainnya';
        });

        $now = Carbon::now('Asia/Jakarta');
        $day = $now->dayOfWeekIso;
        $time = $now->format('H:i');

        $isOpen = false;

        if (in_array($day, [1, 2, 3, 4])) {
            $isOpen = $time >= '08:00' && $time <= '16:00';
        } elseif ($day === 5) {
            $isOpen = $time >= '08:00' && $time <= '14:00';
        }

        $jadwal = JadwalDokter::with([
            'dokter.user',
            'dokter.spesialisasi'
        ])
        ->where('aktif', true)
        ->orderBy('jam_mulai')
        ->limit(3)
        ->get();

        // Get doctors scheduled for today
        $hariSekarang = $now->locale('id')->translatedFormat('l');
        $doktersHariIni = Dokter::with([
            'user',
            'spesialisasi',
            'jadwalDokter'
        ])
        ->whereHas('jadwalDokter', function ($query) use ($hariSekarang) {
            $query->where('hari', $hariSekarang)
                  ->where('aktif', true);
        })
        ->get();

        return view('pasien.beranda', compact(
            'dokters',
            'spesialisasiGroups',
            'isOpen',
            'jadwal',
            'doktersHariIni',
            'hariSekarang'
        ));
    }
}