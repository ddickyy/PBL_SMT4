<?php

namespace App\Filament\Resources\Prodis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProdiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Prodi')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama prodi.')
                    ->schema([
                        TextInput::make('nama_prodi')
                            ->label('Nama Prodi')
                            ->placeholder('Contoh: Teknik Informatika')
                            ->required()
                            ->maxLength(50),
                        
                        Select::make('id_jurusan')
                            ->label('Jurusan')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->required()
                            ->preload(),

                    ])->columnSpanFull(),
            ]);
    }
}
