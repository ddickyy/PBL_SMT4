<?php

namespace App\Filament\Resources\KuotaHarians\Pages;

use App\Filament\Resources\KuotaHarians\KuotaHarianResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKuotaHarian extends CreateRecord
{
    protected static string $resource = KuotaHarianResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
