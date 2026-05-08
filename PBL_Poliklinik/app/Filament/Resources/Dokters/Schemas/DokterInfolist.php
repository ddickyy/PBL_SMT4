<?php

namespace App\Filament\Resources\Dokters\Schemas;

use App\Models\Dokter;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DokterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokter')
                    ->icon('heroicon-o-identification')
                    ->description('Informasi utama mengenai dokter.')
                    ->schema([

                        Group::make([
                            TextEntry::make('sip_dokter')
                                ->label('SIP Dokter')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
    
                            TextEntry::make('user.nama')
                                ->label('Nama')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
    
                            TextEntry::make('spesialisasi.nama_spesialisasi')
                                ->label('Spesialisasi')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
    
                            TextEntry::make('user.email')
                                ->label('Email')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
                            ]),

                        Group::make([
                            TextEntry::make('no_hp')
                                ->label('Nomor Handphone')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
    
                            TextEntry::make('user.foto')
                                ->label('Foto')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
    
                            TextEntry::make('created_at')
                                ->label('Dibuat pada')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
    
                            TextEntry::make('updated_at')
                                ->label('Diperbarui pada')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
                        ])

                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
