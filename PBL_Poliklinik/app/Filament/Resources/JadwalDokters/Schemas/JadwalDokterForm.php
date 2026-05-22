<?php

namespace App\Filament\Resources\JadwalDokters\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\Dokter;

class JadwalDokterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Jadwal Dokter')
                    ->icon('heroicon-o-calendar-days')
                    ->description('Masukkan informasi jadwal dokter.')
                    ->schema([
                        Select::make('id_dokter')
                            ->label('Dokter')
                            ->options(
                                Dokter::with('user')
                                    ->get()
                                    ->pluck('user.nama', 'id_dokter')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('hari')
                            ->label('Hari')
                            ->options([
                                'Senin' => 'Senin',
                                'Selasa' => 'Selasa',
                                'Rabu' => 'Rabu',
                                'Kamis' => 'Kamis',
                                'Jumat' => 'Jumat',
                            ])
                            ->required()
                            ->searchable(),

                        TimePicker::make('jam_mulai')
                            ->label('Jam Mulai')
                            ->seconds(false)
                            ->required(),

                        TimePicker::make('jam_selesai')
                            ->label('Jam Selesai')
                            ->seconds(false)
                            ->required(),

                        TextInput::make('durasi_menit')
                            ->label('Durasi per sesi (menit)')
                            ->placeholder('Masukkan estimasi durasi per sesi (menit)')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(1440),

                        TextInput::make('kuota_maksimal')
                            ->label('Kuota Harian')
                            ->placeholder('Masukkan kuota harian untuk jadwal ini')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->dehydrated(false),

                        Toggle::make('aktif')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
