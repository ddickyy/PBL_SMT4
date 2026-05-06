<?php

namespace App\Filament\Resources\Tendiks\Pages;

use App\Filament\Resources\Tendiks\TendikResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTendik extends CreateRecord
{
    protected static string $resource = TendikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
