<?php

namespace App\Filament\Resources\Reservasis\Pages;

use App\Filament\Resources\Reservasis\ReservasiResource;
use App\Models\JadwalDokter;
use App\Models\KuotaHarian;
use App\Models\Reservasi;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateReservasi extends CreateRecord
{
    protected static string $resource = ReservasiResource::class;

    protected function handleRecordCreation(array $data): Reservasi
    {
        // AMBIL JADWAL
        $jadwal = JadwalDokter::findOrFail(
            $data['id_jadwal']
        );

        // AMBIL KUOTA
        $kuota = KuotaHarian::where(
            'id_jadwal',
            $jadwal->id_jadwal
        )
        ->whereDate(
            'tanggal',
            $data['tanggal_reservasi']
        )
        ->first();

        // VALIDASI KUOTA
        if (! $kuota) {

            throw new \Exception(
                'Kuota harian belum tersedia.'
            );
        }

        // VALIDASI PENUH
        if (
            $kuota->kuota_terisi >=
            $kuota->kuota_maksimal
        ) {

            throw new \Exception(
                'Kuota reservasi sudah penuh.'
            );
        }

        // HITUNG ANTRIAN
        $nomorAntrian =
            $kuota->kuota_terisi + 1;

        // HITUNG ESTIMASI JAM
        $jamMulai = Carbon::parse(
            $jadwal->jam_mulai
        );

        $estimasiJam = $jamMulai
            ->copy()
            ->addMinutes(
                ($nomorAntrian - 1)
                * $jadwal->durasi_menit
            );

        // SIMPAN
        $reservasi = Reservasi::create([
            'id_user' => $data['id_user'],
            'id_jadwal' => $data['id_jadwal'],
            'tanggal_reservasi' => $data['tanggal_reservasi'],
            'nomor_antrian' => $nomorAntrian,
            'estimasi_jam' => $estimasiJam->format('H:i:s'),
            'status' => $data['status'],
        ]);

        // UPDATE KUOTA
        $kuota->increment(
            'kuota_terisi'
        );

        return $reservasi;
    }
}