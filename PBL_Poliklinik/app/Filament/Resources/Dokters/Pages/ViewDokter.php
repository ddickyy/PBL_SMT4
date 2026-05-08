<?php

namespace App\Filament\Resources\Dokters\Pages;

use App\Filament\Resources\Dokters\DokterResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDokter extends ViewRecord
{
    protected static string $resource = DokterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali') 
                ->url(DokterResource::getUrl('index'))
                ->color('success'),
            EditAction::make(),
        ];
    }
}
