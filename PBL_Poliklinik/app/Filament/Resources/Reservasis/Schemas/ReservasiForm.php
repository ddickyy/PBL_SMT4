<?php

namespace App\Filament\Resources\Reservasis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReservasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Reservasi')
                    ->icon('heroicon-o-calendar-days')
                    ->description('Masukkan informasi reservasi.')
                    ->schema([
                        Select::make('id_user')
                            ->label('Pengguna')
                            ->relationship('user', 'nama')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('id_jadwal')
                            ->label('Jadwal Dokter')
                            ->relationship('jadwal', 'hari')
                            ->required()
                            ->searchable()
                            ->preload(),

                        DatePicker::make('tanggal_reservasi')
                            ->label('Tanggal Reservasi')
                            ->required(),

                        TextInput::make('nomor_antrian')
                            ->disabled()
                            ->dehydrated(false),

                        TimePicker::make('estimasi_jam')
                            ->label('Estimasi Jam')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'dikonfirmasi' => 'Dikonfirmasi',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan'
                            ])
                            ->required()
                            ->searchable(),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
