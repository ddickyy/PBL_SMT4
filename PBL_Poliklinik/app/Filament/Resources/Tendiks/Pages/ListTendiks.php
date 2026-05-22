<?php

namespace App\Filament\Resources\Tendiks\Pages;

use App\Filament\Resources\Tendiks\TendikResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTendiks extends ListRecords
{
    protected static string $resource = TendikResource::class;


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => TendikResource::canCreate()),        
        ];
    }
}
