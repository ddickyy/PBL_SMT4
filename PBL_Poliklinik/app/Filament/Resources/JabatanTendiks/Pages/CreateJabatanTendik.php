<?php

namespace App\Filament\Resources\JabatanTendiks\Pages;

use App\Filament\Resources\JabatanTendiks\JabatanTendikResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJabatanTendik extends CreateRecord
{
    protected static string $resource = JabatanTendikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
