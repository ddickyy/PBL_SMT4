<?php

namespace App\Filament\Resources\JabatanTendiks\Pages;

use App\Filament\Resources\JabatanTendiks\JabatanTendikResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditJabatanTendik extends EditRecord
{
    protected static string $resource = JabatanTendikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
