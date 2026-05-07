<?php

namespace App\Filament\Resources\Dosens\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DosenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dosen')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama dosen.')
                    ->schema([
                        TextInput::make('nidn')
                            ->label('NIDN')
                            ->placeholder('Contoh: 244107020228')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->helperText('NIP harus unik.'),
                            
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

                    ])->columnSpanFull(),
            ]);
    }
}
