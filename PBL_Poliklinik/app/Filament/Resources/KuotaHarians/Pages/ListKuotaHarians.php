<?php

namespace App\Filament\Resources\KuotaHarians\Pages;

use App\Filament\Resources\KuotaHarians\KuotaHarianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKuotaHarians extends ListRecords
{
    protected static string $resource = KuotaHarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
