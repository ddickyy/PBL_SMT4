<?php

namespace App\Filament\Resources\Dokters\Schemas;

use App\Models\Dokter;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DokterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_user')
                    ->numeric(),
                TextEntry::make('id_spesialisasi')
                    ->numeric(),
                TextEntry::make('sip_dokter'),
                TextEntry::make('no_hp')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Dokter $record): bool => $record->trashed()),
            ]);
    }
}
