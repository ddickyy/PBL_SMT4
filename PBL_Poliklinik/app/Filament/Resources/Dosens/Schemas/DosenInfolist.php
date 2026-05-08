<?php

namespace App\Filament\Resources\Dosens\Schemas;

use App\Models\Dosen;
use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;

class DosenInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dosen')
                    ->icon('heroicon-s-user')
                    ->description('Informasi utama mengenai dosen.')
                    ->schema([

                        Group::make([
                            TextEntry::make('nidn')
                                ->label('NIDN')
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
                            TextEntry::make('created_at')
                                ->label('Tanggal Dibuat')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-calendar')
                                ->placeholder('-'),
    
                            TextEntry::make('updated_at')
                                ->label('Tanggal Diperbarui')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-calendar')
                                ->placeholder('-'),
                        ])

                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
