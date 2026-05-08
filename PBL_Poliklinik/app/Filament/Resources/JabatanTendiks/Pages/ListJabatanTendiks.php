<?php

namespace App\Filament\Resources\JabatanTendiks\Pages;

use App\Filament\Resources\JabatanTendiks\JabatanTendikResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJabatanTendiks extends ListRecords
{
    protected static string $resource = JabatanTendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
