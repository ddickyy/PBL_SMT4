<?php

namespace App\Filament\Resources\RiwayatStatusReservasis\Pages;

use App\Filament\Resources\RiwayatStatusReservasis\RiwayatStatusReservasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatStatusReservasis extends ListRecords
{
    protected static string $resource = RiwayatStatusReservasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
