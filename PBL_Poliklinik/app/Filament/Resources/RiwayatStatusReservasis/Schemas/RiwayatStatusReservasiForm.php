<?php

namespace App\Filament\Resources\RiwayatStatusReservasis\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class RiwayatStatusReservasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Riwayat Status Reservasi')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('Masukkan informasi riwayat status reservasi.')
                    ->schema([
                        Select::make('id_reservasi')
                            ->label('Reservasi Hari Ini')
                            ->options(
                                \App\Models\Reservasi::with('user')
                                    ->whereDate('tanggal_reservasi', today())
                                    ->get()
                                    ->mapWithKeys(function ($reservasi) {
                                        return [
                                            $reservasi->id_reservasi =>
                                                $reservasi->nomor_antrian .
                                                ' - ' .
                                                $reservasi->user->nama
                                        ];
                                    })
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set) {

                                $reservasi = \App\Models\Reservasi::find($state);

                                $set(
                                    'status_lama',
                                    $reservasi?->status
                                );
                            }),

                        Hidden::make('status_lama'),                            

                        Select::make('status_baru')
                            ->label('Status Baru')
                            ->options([
                                'pending' => 'Pending',
                                'dikonfirmasi' => 'Dikonfirmasi',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan'
                            ])
                            ->required()
                            ->searchable()
                            ->rule(function (Get $get) {
                                return function (string $attribute, $value, \Closure $fail) use ($get) {

                                    if ($value === $get('status_lama')) {
                                        $fail('Status baru tidak boleh sama dengan status lama.');
                                    }
                                };
                            }),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->required()
                            ->maxLength(255),

                        Hidden::make('diubah_oleh')
                            ->default(Auth::user()?->id_user),
                            
                     ])->columnSpanFull(),
            ]);
    }
}
