<?php

namespace App\Filament\Resources\RekamMedis\Pages;

use App\Filament\Resources\RekamMedis\RekamMedisResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRekamMedis extends ViewRecord
{
    protected static string $resource = RekamMedisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}