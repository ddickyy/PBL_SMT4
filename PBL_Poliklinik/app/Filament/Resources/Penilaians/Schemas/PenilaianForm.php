<?php

namespace App\Filament\Resources\Penilaians\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Carbon\Carbon;

class PenilaianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Penilaian')
                    ->icon('heroicon-o-star')
                    ->description('Masukkan informasi penilaian reservasi.')
                    ->schema([
                        Select::make('id_reservasi')
                            ->label('Reservasi')
                            ->options(
                                \App\Models\Reservasi::with('user')
                                    ->orderByDesc('tanggal_reservasi')
                                    ->orderByDesc('nomor_antrian')
                                    ->get()
                                    ->mapWithKeys(fn ($reservasi) => [
                                        $reservasi->id_reservasi =>
                                            'Antrian #' . $reservasi->nomor_antrian .
                                            ' - ' .
                                            Carbon::parse($reservasi->tanggal_reservasi)
                                                ->format('d F Y') .
                                            ' - ' .
                                            $reservasi->user->nama
                                    ])
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Textarea::make('kritik')
                            ->label('Kritik')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('saran')
                            ->label('Saran')
                            ->rows(3)
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
