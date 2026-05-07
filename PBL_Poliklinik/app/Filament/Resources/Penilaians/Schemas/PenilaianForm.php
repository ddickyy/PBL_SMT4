<?php

namespace App\Filament\Resources\Penilaians\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PenilaianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Penilaian')
                    ->icon('heroicon-o-star')
                    ->description('Masukkan informasi penilaian reservasi.')
                    ->schema([
                        Select::make('id_reservasi')
                            ->label('Reservasi')
                            ->relationship('reservasi', 'id_reservasi')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Textarea::make('kritik')
                            ->label('Kritik')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('saran')
                            ->label('Saran')
                            ->rows(3)
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
