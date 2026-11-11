<?php

namespace App\Filament\Resources\RiwayatStatusReservasis\Pages;

use App\Filament\Resources\RiwayatStatusReservasis\RiwayatStatusReservasiResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRiwayatStatusReservasi extends ViewRecord
{
    protected static string $resource = RiwayatStatusReservasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(RiwayatStatusReservasiResource::getUrl('index'))
                ->color('success'),
        ];
    }
}
