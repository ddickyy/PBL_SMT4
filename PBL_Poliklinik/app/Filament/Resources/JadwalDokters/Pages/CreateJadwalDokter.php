<?php

namespace App\Filament\Resources\JadwalDokters\Pages;

use App\Filament\Resources\JadwalDokters\JadwalDokterResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\KuotaHarian;

class CreateJadwalDokter extends CreateRecord
{
    protected static string $resource = JadwalDokterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(
            'view',
            ['record' => $this->record]
        );
    }

    protected function afterCreate(): void
    {
        $jadwal = $this->record;

        $hariMap = [
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
        ];

        $targetDay = $hariMap[$jadwal->hari];

        $today = now();
        $endDate = now()->addWeeks(2);

        for (
            $date = $today->copy();
            $date <= $endDate;
            $date->addDay()
        ) {

            if ($date->dayOfWeekIso !== $targetDay) {
                continue;
            }

            KuotaHarian::firstOrCreate(
                [
                    'id_jadwal' => $jadwal->id_jadwal,
                    'tanggal' => $date->toDateString(),
                ],
                [
                    'kuota_terisi' => 0,
                    'kuota_maksimal' => $this->data['kuota_maksimal'],
                ]
            );
        }
    }
}