<?php

namespace App\Filament\Resources\JabatanTendiks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JabatanTendikForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Jabatan Tendik')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama jabatan tendik.')
                    ->schema([
                        TextInput::make('nama_jabatan')
                            ->label('Jabatan Tendik')
                            ->placeholder('Contoh: Arsiparis')
                            ->required()
                            ->maxLength(50),
                    ])->columnSpanFull(),
            ]);
    }
}
