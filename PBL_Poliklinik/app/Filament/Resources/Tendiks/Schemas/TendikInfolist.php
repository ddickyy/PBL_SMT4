<?php

namespace App\Filament\Resources\Tendiks\Schemas;

use App\Models\Tendik;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;

class TendikInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tendik')
                    ->icon('heroicon-s-user')
                    ->description('Informasi utama mengenai tendik.')
                    ->schema([
                        Group::make([
                            TextEntry::make('nip')
                                ->label('NIP')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('no_hp')
                                ->label('Nomor Handphone')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('user.nama')
                                ->label('Nama')
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
                            ImageEntry::make('user.foto')
                                ->label('Foto')
                                ->placeholder('-'),

                            TextEntry::make('created_at')
                                ->label('Tanggal Dibuat')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('updated_at')
                                ->label('Tanggal Diperbarui')
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
