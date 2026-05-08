<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Admin')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama admin.')
                    ->schema([
                        Select::make('id_user')
                            ->label('Pengguna')
                            ->relationship('user', 'nama')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->searchable()
                            ->preload(),

                        TextInput::make('tipe_admin')
                            ->label('Tipe Admin')
                            ->required()
                            ->maxLength(50),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
