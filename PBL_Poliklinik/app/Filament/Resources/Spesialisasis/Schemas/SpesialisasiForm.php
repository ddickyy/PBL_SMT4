<?php

namespace App\Filament\Resources\Spesialisasis\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class SpesialisasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Keahlian')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama spesialisasi.')
                    ->schema([
                        TextInput::make('nama_spesialisasi')
                            ->label('Nama Keahlian')
                            ->placeholder('Contoh: Ahli Gigi')
                            ->required()
                            ->maxLength(50),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Deskripsi singkat tentang spesialisasi ini.')
                            ->maxLength(255),
                    ])->columnSpanFull(),
            ]);
    }
}
