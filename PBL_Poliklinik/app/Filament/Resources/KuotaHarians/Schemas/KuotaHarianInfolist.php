<?php

namespace App\Filament\Resources\KuotaHarians\Schemas;

use App\Models\KuotaHarian;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KuotaHarianInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kuota Harian')
                    ->icon('heroicon-o-identification')
                    ->description('Informasi kuota harian.')
                    ->schema([
                        TextEntry::make('jadwal.dokter.user.nama')
                            ->label('Dokter')
                            ->badge()
                            ->color('success'),

                        TextEntry::make('jadwal.hari')
                            ->label('Hari Praktik')
                            ->badge()
                            ->color('warning'),

                        TextEntry::make('tanggal')
                            ->label('Tanggal')
                            ->date('d F Y')
                            ->icon('heroicon-o-calendar-days'),

                        TextEntry::make('kuota_terisi')
                            ->label('Kuota Terisi')
                            ->numeric()
                            ->icon('heroicon-o-users'),

                        TextEntry::make('kuota_maksimal')
                            ->label('Kuota Maksimal')
                            ->numeric()
                            ->icon('heroicon-o-users'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
