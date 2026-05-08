<?php

namespace App\Filament\Resources\Spesialisasis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class SpesialisasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Spesialisasi')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama spesialisasi.')
                    ->schema([
                        TextInput::make('nama_spesialisasi')
                            ->label('Nama Spesialisasi')
                            ->placeholder('Contoh: Dokter Gigi')
                            ->required()
                            ->maxLength(50),
                    ])->columnSpanFull(),
            ]);
    }
}
