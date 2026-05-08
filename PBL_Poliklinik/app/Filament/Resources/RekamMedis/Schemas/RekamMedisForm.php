<?php

namespace App\Filament\Resources\RekamMedis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\Dokter;

class RekamMedisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Rekam Medis')
                    ->icon('heroicon-o-document-text')
                    ->description('Masukkan informasi rekam medis.')
                    ->schema([
                        Select::make('id_reservasi')
                            ->label('Reservasi')
                            ->relationship('reservasi', 'id_reservasi')
                            ->required()
                            ->searchable()
                            ->preload(),

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

                        Textarea::make('diagnosis')
                            ->label('Diagnosis')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),

                        DatePicker::make('tanggal_periksa')
                            ->label('Tanggal Periksa')
                            ->required(),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
