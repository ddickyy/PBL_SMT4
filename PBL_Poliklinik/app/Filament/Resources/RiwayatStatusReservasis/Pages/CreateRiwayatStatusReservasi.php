<?php

namespace App\Filament\Resources\RiwayatStatusReservasis\Pages;

use App\Filament\Resources\RiwayatStatusReservasis\RiwayatStatusReservasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRiwayatStatusReservasi extends CreateRecord
{
    protected static string $resource = RiwayatStatusReservasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function afterCreate(): void
    {
        $reservasi = $this->record->reservasi;

        $reservasi->update([
            'status' => $this->record->status_baru,
        ]);
    }
}
