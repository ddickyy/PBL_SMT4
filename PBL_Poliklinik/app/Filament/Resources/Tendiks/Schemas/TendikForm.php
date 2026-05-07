<?php

namespace App\Filament\Resources\Tendiks\Schemas;

use Dom\Text;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TendikForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tendik')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama tendik.')
                    ->schema([
                        TextInput::make('nip')
                            ->label('NIP')
                            ->required()
                            ->placeholder('Contoh : 1234567890')
                            ->numeric()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->helperText('NIP harus unik.'),

                        Select::make('id_jabatan')
                            ->label('Jabatan')
                            ->required()
                            ->relationship('jabatan', 'nama_jabatan')
                            ->searchable()
                            ->preload(),

                        Select::make('id_user')
                            ->label('Pengguna')
                            ->required()
                            ->relationship('user', 'nama')
                            ->searchable()
                            ->preload(),

                        TextInput::make('no_hp')
                            ->label('Nomor Handphone')
                            ->placeholder('Contoh : 08123456789')
                            ->numeric()
                            ->maxLength(50),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
