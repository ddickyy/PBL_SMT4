<?php

namespace App\Filament\Resources\Reservasis\Pages;

use App\Filament\Resources\Reservasis\ReservasiResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReservasi extends ViewRecord
{
    protected static string $resource = ReservasiResource::class;

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
                ->url(ReservasiResource::getUrl('index'))
                ->color('success'),
            EditAction::make(),
        ];
    }
}