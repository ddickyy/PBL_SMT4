<?php

namespace App\Filament\Resources\RiwayatStatusReservasis\Pages;

use App\Filament\Resources\RiwayatStatusReservasis\RiwayatStatusReservasiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatStatusReservasi extends EditRecord
{
    protected static string $resource = RiwayatStatusReservasiResource::class;

        protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('view', ['record' => $this->record]);
        }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
