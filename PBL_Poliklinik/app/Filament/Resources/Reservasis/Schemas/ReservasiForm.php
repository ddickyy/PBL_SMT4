<?php

namespace App\Filament\Resources\Reservasis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Closure;
use Carbon\Carbon;
use Filament\Schemas\Components\Utilities\Get;

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
                            ->label('Pasien')
                            ->relationship('user', 'nama')
                            ->required()
                            ->searchable()
                            ->preload(),

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

                        DatePicker::make('tanggal_reservasi')
                            ->label('Tanggal Reservasi')
                            ->required()
                            ->rule(function (Get $get) {

                                return function (
                                    string $attribute,
                                    $value,
                                    Closure $fail
                                ) use ($get) {

                                    $jadwal = \App\Models\JadwalDokter::find(
                                        $get('id_jadwal')
                                    );

                                    if (! $jadwal) {
                                        return;
                                    }

                                    $hariInput = Carbon::parse($value)
                                        ->locale('id')
                                        ->dayName;

                                    $hariInput = ucfirst($hariInput);

                                    if ($hariInput !== $jadwal->hari) {

                                        $fail(
                                            'Tanggal reservasi harus sesuai dengan hari jadwal dokter.'
                                        );
                                    }
                                };
                            }),

                        Hidden::make('nomor_antrian')
                            ->disabled()
                            ->dehydrated(false),

                        TimePicker::make('estimasi_jam')
                            ->label('Estimasi Jam')
                            ->required()
                            ->rule(function (Get $get) {

                                return function (
                                    string $attribute,
                                    $value,
                                    Closure $fail
                                ) use ($get) {

                                    $jadwal = \App\Models\JadwalDokter::find(
                                        $get('id_jadwal')
                                    );

                                    if (! $jadwal) {
                                        return;
                                    }

                                    $jamInput = Carbon::parse($value)->format('H:i:s');

                                    if (
                                        $jamInput < $jadwal->jam_mulai ||
                                        $jamInput > $jadwal->jam_selesai
                                    ) {

                                        $fail(
                                            'Jam reservasi harus sesuai jadwal praktik dokter.'
                                        );
                                    }
                                };
                            }),

                        Radio::make('status')
                            ->label('Status')
                            ->options([
                                'menunggu' => 'Menunggu',
                                'dikonfirmasi' => 'Dikonfirmasi',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan'
                            ])
                            ->required(),

                        Toggle::make('viewed')
                            ->label('Telah Dilihat')
                            ->inline(false),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
