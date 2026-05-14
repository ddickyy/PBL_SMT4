<?php

namespace App\Filament\Resources\RekamMedis\Schemas;

use App\Models\RekamMedis;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RekamMedisInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Rekam Medis')
                    ->icon('heroicon-o-document-text')
                    ->description('Informasi utama mengenai rekam medis pasien.')
                    ->schema([

                    Group::make([

                        Section::make('Informasi Rekam Medis')
                            ->icon('heroicon-o-document-text')
                            ->compact()
                            ->schema([

                                TextEntry::make('reservasi.id_reservasi')
                                    ->label('ID Reservasi')
                                    ->badge()
                                    ->color('primary')
                                    ->placeholder('-'),

                                TextEntry::make('dokter.user.nama')
                                    ->label('Dokter')
                                    ->badge()
                                    ->color('success')
                                    ->placeholder('-'),

                                TextEntry::make('tanggal_periksa')
                                    ->label('Tanggal Periksa')
                                    ->date('d F Y')
                                    ->icon('heroicon-o-calendar-days')
                                    ->placeholder('-'),

                                TextEntry::make('diagnosis')
                                    ->label('Diagnosis')
                                    ->markdown()
                                    ->placeholder('Tidak ada diagnosis.')
                                    ->columnSpanFull(),

                                TextEntry::make('catatan')
                                    ->label('Catatan')
                                    ->markdown()
                                    ->placeholder('Tidak ada catatan tambahan.')
                                    ->columnSpanFull(),

                            ])
                            ->columns(2),

                    ])
                    ->columnSpan(2),

                    Group::make([

                        Section::make('Informasi Pasien')
                            ->icon('heroicon-o-user')
                            ->compact()
                            ->schema([

                                TextEntry::make('reservasi.user.nama')
                                    ->label('Nama Pasien')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('reservasi.user.jenis_pasien')
                                    ->label('Jenis Pasien')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('reservasi.user.identitas')
                                    ->label(function ($record) {

                                        if ($record->reservasi->user->mahasiswa) {
                                            return 'NIM';
                                        }

                                        if ($record->reservasi->user->dosen) {
                                            return 'NIDN';
                                        }

                                        if ($record->reservasi->user->tendik) {
                                            return 'NIP';
                                        }

                                        return 'Identitas';
                                    })
                                    ->badge()
                                    ->color('gray'),

                                TextEntry::make('reservasi.user.email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope'),
                            ])
                            ->columns(1),

                    ])
                    ->columnSpan(1),

                    Section::make('Metadata')
                        ->icon('heroicon-o-information-circle')
                        ->compact()
                        ->schema([

                            TextEntry::make('created_at')
                                ->label('Tanggal Dibuat')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-calendar')
                                ->placeholder('-'),

                            TextEntry::make('updated_at')
                                ->label('Terakhir Diupdate')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-pencil-square')
                                ->placeholder('-'),

                            TextEntry::make('deleted_at')
                                ->label('Tanggal Dihapus')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-trash')
                                ->color('danger')
                                ->placeholder('-')
                                ->visible(fn (RekamMedis $record): bool => $record->trashed()),

                        ])
                        ->columnSpanFull(),

                ])->columns(3)
                ->columnSpanFull(),

            ]);
    }
}