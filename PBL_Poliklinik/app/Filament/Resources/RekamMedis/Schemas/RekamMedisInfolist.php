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

                            TextEntry::make('reservasi.id_reservasi')
                                ->label('ID Reservasi')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('dokter.user.nama')
                                ->label('Dokter Pemeriksa')
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
                        ->columnSpan(2),

                        Group::make([

                            IconEntry::make('reservasi.status')
                                ->label('Status Reservasi')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-circle')
                                ->falseIcon('heroicon-o-x-circle'),

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
                        ->columnSpan(1),

                    ])
                    ->columns(3)
                    ->columnSpanFull(),

            ]);
    }
}