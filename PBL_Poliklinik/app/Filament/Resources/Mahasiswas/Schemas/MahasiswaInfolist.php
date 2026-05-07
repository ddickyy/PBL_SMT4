<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use App\Models\Mahasiswa;
use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Group;

class MahasiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Mahasiswa')
                    ->icon('heroicon-o-identification')
                    ->description('Informasi utama mengenai mahasiswa.')
                    ->schema([

                        Group::make([
                            TextEntry::make('nim')
                                ->label('NIM')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
                            
                            TextEntry::make('no_hp')
                                ->label('Nomor Handphone')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('prodi.nama_prodi')
                                ->label('Prodi')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            ImageEntry::make('user.foto')
                                ->label('Foto')
                                ->placeholder('-'),
                        ]),
                                
                        Group::make([
                           TextEntry::make('user.nama')
                                ->label('Nama Mahasiswa')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('user.email')
                            ->label('Email')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),
    
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
                        ]),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
