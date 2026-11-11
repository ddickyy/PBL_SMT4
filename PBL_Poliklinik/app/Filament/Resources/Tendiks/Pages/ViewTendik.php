<?php

namespace App\Filament\Resources\Tendiks\Pages;

use App\Filament\Resources\JabatanTendiks\JabatanTendikResource;
use App\Filament\Resources\Tendiks\TendikResource;
use App\Models\JabatanTendik;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTendik extends ViewRecord
{
    protected static string $resource = TendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali') 
                ->url(TendikResource::getUrl('index'))
                ->color('success'),
            EditAction::make()
                ->visible(fn () => TendikResource::canEdit($this->record)),
        ];
    }
}
