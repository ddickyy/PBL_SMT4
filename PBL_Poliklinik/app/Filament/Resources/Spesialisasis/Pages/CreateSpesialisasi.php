<?php

namespace App\Filament\Resources\Spesialisasis\Pages;

use App\Filament\Resources\Spesialisasis\SpesialisasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSpesialisasi extends CreateRecord
{
    protected static string $resource = SpesialisasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
