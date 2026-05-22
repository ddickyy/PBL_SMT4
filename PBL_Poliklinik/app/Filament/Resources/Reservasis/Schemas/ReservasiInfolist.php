<?php

namespace App\Filament\Resources\Reservasis\Schemas;

use App\Models\Reservasi;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReservasiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Detail Reservasi')
                    ->icon('heroicon-o-calendar-days')
                    ->description('Informasi reservasi dan pasien.')
                    ->schema([

                        Group::make([

                            Section::make('Informasi Reservasi')
                                ->icon('heroicon-o-clipboard-document-list')
                                ->schema([

                                    TextEntry::make('jadwal.dokter.user.nama')
                                        ->label('Dokter')
                                        ->badge()
                                        ->color('success'),

                                    TextEntry::make('jadwal.hari')
                                        ->label('Hari Praktik')
                                        ->badge()
                                        ->color('warning'),

                                    TextEntry::make('tanggal_reservasi')
                                        ->label('Tanggal Pemeriksaan')
                                        ->date('d F Y')
                                        ->icon('heroicon-o-calendar-days'),

                                    TextEntry::make('estimasi_jam')
                                        ->label('Estimasi Jam')
                                        ->time('H:i')
                                        ->icon('heroicon-o-clock'),

                                    TextEntry::make('nomor_antrian')
                                        ->label('Nomor Antrian')
                                        ->badge()
                                        ->color('danger'),

                                    TextEntry::make('status')
                                        ->label('Status Reservasi')
                                        ->badge()
                                        ->colors([
                                            'warning' => 'pending',
                                            'success' => 'dikonfirmasi',
                                            'primary' => 'selesai',
                                            'danger' => 'dibatalkan',
                                        ]),

                                    TextEntry::make('created_at')
                                        ->label('Tanggal Reservasi Dibuat')
                                        ->date('d F Y')
                                        ->icon('heroicon-o-calendar-days'),

                                ])
                                ->columns(2),

                        ])
                        ->columnSpan(2),

                        Group::make([

                            Section::make('Informasi Pasien')
                                ->icon('heroicon-o-user')
                                ->schema([

                                    TextEntry::make('user.nama')
                                        ->label('Nama Pasien')
                                        ->badge()
                                        ->color('primary'),

                                    TextEntry::make('user.email')
                                        ->label('Email')
                                        ->icon('heroicon-o-envelope'),

                                    TextEntry::make('user.identitas')
                                        ->label(function ($record) {

                                            if ($record->user->mahasiswa) {
                                                return 'NIM';
                                            }

                                            if ($record->user->dosen) {
                                                return 'NIDN';
                                            }

                                            if ($record->user->tendik) {
                                                return 'NIP';
                                            }

                                            return 'Identitas';
                                        })
                                        ->badge()
                                        ->color('gray'),


                                ]),
                        ])
                        ->columnSpan(1),

                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}