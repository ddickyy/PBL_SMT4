<?php

namespace App\Filament\Resources\Jurusans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JurusanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Jurusan')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama jurusan.')
                    ->schema([
                        TextInput::make('nama_jurusan')
                            ->label('Nama Jurusan')
                            ->placeholder('Contoh: Teknik Informatika')
                            ->required()
                            ->maxLength(50),
                    ])->columnSpanFull(),
            ]);
    }
}
