<?php

namespace App\Filament\Resources\KuotaHarians\Pages;

use App\Filament\Resources\KuotaHarians\KuotaHarianResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewKuotaHarian extends ViewRecord
{
    protected static string $resource = KuotaHarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(KuotaHarianResource::getUrl('index'))
                ->color('success'),
            EditAction::make(),
        ];
    }
}
