<?php

namespace App\Filament\Resources\JadwalDokters\Schemas;

use App\Models\JadwalDokter;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JadwalDokterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Jadwal Dokter')
                    ->icon('heroicon-o-calendar-days')
                    ->description('Informasi utama jadwal dokter.')
                    ->schema([

                        Group::make([

                            TextEntry::make('dokter.user.nama')
                                ->label('Nama Dokter')
                                ->badge()
                                ->color('primary'),

                            TextEntry::make('hari')
                                ->label('Hari')
                                ->badge()
                                ->color('success'),

                            TextEntry::make('jam_mulai')
                                ->label('Jam Mulai')
                                ->time('H:i'),

                            TextEntry::make('jam_selesai')
                                ->label('Jam Selesai')
                                ->time('H:i'),

                            TextEntry::make('durasi_menit')
                                ->label('Durasi')
                                ->suffix(' menit'),

                        ])
                        ->columnSpan(2),

                        Group::make([

                            IconEntry::make('aktif')
                                ->label('Status')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-circle')
                                ->falseIcon('heroicon-o-x-circle')
                                ->trueColor('success')
                                ->falseColor('danger'),

                            TextEntry::make('created_at')
                                ->label('Tanggal Dibuat')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-calendar'),

                            TextEntry::make('updated_at')
                                ->label('Terakhir Diupdate')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-pencil-square'),

                            TextEntry::make('deleted_at')
                                ->label('Tanggal Dihapus')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-trash')
                                ->color('danger')
                                ->visible(fn (JadwalDokter $record): bool => $record->trashed()),

                        ])
                        ->columnSpan(1),

                    ])
                    ->columns(3)
                    ->columnSpanFull(),

            ]);
    }
}