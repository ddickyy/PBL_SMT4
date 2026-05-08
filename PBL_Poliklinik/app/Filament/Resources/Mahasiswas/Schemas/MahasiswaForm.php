<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MahasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Mahasiswa')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama mahasiswa.')
                    ->schema([
                        TextInput::make('nim')
                            ->label('NIM')
                            ->placeholder('Contoh: 244107020228')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->helperText('NIM harus unik.'),

                        Select::make('id_user')
                            ->label('Pengguna')
                            ->relationship('user', 'nama')
                            ->required()
                            ->searchable()
                            ->preload(),

                        TextInput::make('no_hp')
                            ->label('Nomor Handphone')
                            ->placeholder('Contoh: 08123456789')
                            ->required()
                            ->maxLength(50),
                            
                        Select::make('id_prodi')
                            ->label('Prodi')
                            ->relationship('prodi', 'nama_prodi')
                            ->required()
                            ->searchable()
                            ->preload(),


                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
