<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                    Section::make('Informasi Role')
                        ->icon('heroicon-o-identification')
                        ->description('Masukkan informasi utama role.')
                        ->schema([
                            TextInput::make('nama_role')
                                ->label('Nama Role')
                                ->placeholder('Contoh: Admin, Dokter, Pasien')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(50)
                                ->helperText('Nama role harus unik.')
                                ->validationMessages([
                                    'required' => 'Nama role wajib diisi.',
                                    'unique' => 'Nama role sudah digunakan.',
                                ])->columnSpanFull(),

                            Textarea::make('deskripsi')
                                ->label('Deskripsi Role')
                                ->placeholder('Masukkan deskripsi role...')
                                ->rows(5)
                                ->maxLength(255)
                                ->helperText('Deskripsi digunakan untuk menjelaskan fungsi role.')
                                ->columnSpanFull(),

                        ])->columnSpanFull(),
            ]);
    }
}