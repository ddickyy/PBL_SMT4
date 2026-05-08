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

                Section::make('Informasi Reservasi')
                    ->icon('heroicon-o-calendar-days')
                    ->description('Informasi utama mengenai reservasi pasien.')
                    ->schema([

                        Group::make([

                            TextEntry::make('user.nama')
                                ->label('Nama Pasien')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('jadwal.dokter.user.nama')
                                ->label('Dokter')
                                ->badge()
                                ->color('success')
                                ->placeholder('-'),

                            TextEntry::make('jadwal.hari')
                                ->label('Hari Praktik')
                                ->badge()
                                ->color('warning')
                                ->placeholder('-'),

                            TextEntry::make('tanggal_reservasi')
                                ->label('Tanggal Reservasi')
                                ->date('d F Y')
                                ->icon('heroicon-o-calendar-days')
                                ->placeholder('-'),

                            TextEntry::make('estimasi_jam')
                                ->label('Estimasi Jam')
                                ->time('H:i')
                                ->icon('heroicon-o-clock')
                                ->placeholder('-'),

                            TextEntry::make('nomor_antrian')
                                ->label('Nomor Antrian')
                                ->badge()
                                ->color('danger')
                                ->placeholder('-'),

                        ])
                        ->columnSpan(2),

                        Group::make([

                            TextEntry::make('status')
                                ->label('Status Reservasi')
                                ->badge()
                                ->colors([
                                    'warning' => 'pending',
                                    'success' => 'confirmed',
                                    'primary' => 'completed',
                                    'danger' => 'cancelled',
                                ]),

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
                                ->visible(fn (Reservasi $record): bool => $record->trashed()),

                        ])
                        ->columnSpan(1),

                    ])
                    ->columns(3)
                    ->columnSpanFull(),

            ]);
    }
}