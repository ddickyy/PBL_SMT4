<?php

namespace App\Filament\Resources\Dokters\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DokterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokter')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama dokter.')
                    ->schema([
                        TextInput::make('sip_dokter')
                            ->label('SIP Dokter')
                            ->placeholder('Contoh: 244107020228')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->helperText('SIP harus unik.'),

                        Select::make('id_user')
                            ->label('Pengguna')
                            ->relationship('user', 'nama')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('id_spesialisasi')
                            ->label('Spesialisasi')
                            ->relationship('spesialisasi', 'nama_spesialisasi')
                            ->required()
                            ->searchable()
                            ->preload(),

                        TextInput::make('no_hp')
                            ->label('Nomor Handphone')
                            ->placeholder('Contoh: 08123456789')
                            ->required()
                            ->maxLength(50),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
