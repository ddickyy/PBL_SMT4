<?php

namespace App\Filament\Resources\Penilaians\Schemas;

use App\Models\Penilaian;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PenilaianInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Penilaian')
                    ->icon('heroicon-o-star')
                    ->description('Informasi penilaian dan feedback pasien.')
                    ->schema([

                        Group::make([

                            TextEntry::make('reservasi.id_reservasi')
                                ->label('ID Reservasi')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('reservasi.user.nama')
                                ->label('Nama Pasien')
                                ->badge()
                                ->color('success')
                                ->placeholder('-'),

                            TextEntry::make('reservasi.jadwal.dokter.user.nama')
                                ->label('Dokter')
                                ->badge()
                                ->color('warning')
                                ->placeholder('-'),

                            TextEntry::make('kritik')
                                ->label('Kritik')
                                ->markdown()
                                ->placeholder('Tidak ada kritik.')
                                ->columnSpanFull(),

                            TextEntry::make('saran')
                                ->label('Saran')
                                ->markdown()
                                ->placeholder('Tidak ada saran.')
                                ->columnSpanFull(),

                        ])
                        ->columnSpan(2),

                        Group::make([

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
                                ->visible(fn (Penilaian $record): bool => $record->trashed()),

                        ])
                        ->columnSpan(1),

                    ])
                    ->columns(3)
                    ->columnSpanFull(),

            ]);
    }
}