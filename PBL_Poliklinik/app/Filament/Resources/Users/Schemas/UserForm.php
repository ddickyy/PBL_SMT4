<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Pengguna')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama pengguna.')
                    ->schema([

                        TextInput::make('nama')
                            ->label('Nama Pengguna')
                            ->placeholder('Contoh: Esatovin')
                            ->required()
                            ->maxLength(50),

                        TextInput::make('email')
                            ->label('Email Pengguna')
                            ->placeholder('Contoh: esatovin@example.com')
                            ->helperText('Email harus unik.')
                            ->required()
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),

                        TextInput::make('password')
                            ->label('Password Pengguna')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                        
                        Select::make('id_role')
                            ->label('Role Pengguna')
                            ->relationship('role', 'nama_role')
                            ->required()
                            ->searchable()
                            ->preload(),

                        CheckboxList::make('permissions')
                            ->relationship(
                                'permissions',
                                'nama_permission'
                            )
                            ->columns(2)
                            ->searchable()
                            ->columnSpanFull(),

                        FileUpload::make('foto')
                            ->label('Foto Pengguna')
                            ->image()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
            ]);
    }
}
