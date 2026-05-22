<?php

namespace App\Filament\Resources\Dosens\Pages;

use App\Filament\Resources\Dosens\DosenResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDosen extends ViewRecord
{
    protected static string $resource = DosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(DosenResource::getUrl('index'))
                ->color('success'),
            EditAction::make()
                ->visible(fn () => DosenResource::canEdit($this->record)),
        ];
    }
}
