<?php

namespace App\Filament\Resources\Mahasiswas\Pages;

use App\Filament\Resources\Mahasiswas\MahasiswaResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMahasiswa extends ViewRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(MahasiswaResource::getUrl('index'))
                ->color('success'),
            EditAction::make()
                ->visible(fn () => MahasiswaResource::canEdit($this->record)),
        ];
    }
}
