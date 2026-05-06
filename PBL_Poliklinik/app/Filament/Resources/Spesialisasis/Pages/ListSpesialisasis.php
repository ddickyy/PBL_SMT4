<?php

namespace App\Filament\Resources\Spesialisasis\Pages;

use App\Filament\Resources\Spesialisasis\SpesialisasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpesialisasis extends ListRecords
{
    protected static string $resource = SpesialisasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
