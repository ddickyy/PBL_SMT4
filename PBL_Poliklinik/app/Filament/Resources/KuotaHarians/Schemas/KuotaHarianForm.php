<?php

namespace App\Filament\Resources\KuotaHarians\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KuotaHarianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kuota Harian')
                    ->icon('heroicon-o-identification')
                    ->description('Masukkan informasi utama kuota harian.')
                    ->schema([
                        Select::make('id_jadwal')
                            ->label('Jadwal Dokter')
                            ->options(

                                \App\Models\JadwalDokter::with('dokter.user')
                                    ->where('aktif', true)
                                    ->get()
                                    ->mapWithKeys(function ($jadwal) {

                                        return [
                                            $jadwal->id_jadwal =>

                                                $jadwal->dokter->user->nama .
                                                ' - ' .
                                                $jadwal->hari .
                                                ' (' .
                                                $jadwal->jam_mulai .
                                                ' - ' .
                                                $jadwal->jam_selesai .
                                                ')'
                                        ];
                                    })

                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required(),
                        TextInput::make('kuota_maksimal')
                            ->label('Kuota')
                            ->placeholder('Contoh: 50')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                    ])->columnSpanFull(),
            ]);
    }
}
