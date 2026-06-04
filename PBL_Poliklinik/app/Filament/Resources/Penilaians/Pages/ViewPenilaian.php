<?php

namespace App\Filament\Resources\Penilaians\Pages;

use App\Filament\Resources\Penilaians\PenilaianResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPenilaian extends ViewRecord
{
    protected static string $resource = PenilaianResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        if (! $this->record->viewed) {
            $this->record->viewed = true;
            $this->record->save();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(PenilaianResource::getUrl('index'))
                ->color('success'),
            EditAction::make(),
        ];
    }
}