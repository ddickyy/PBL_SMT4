<?php

namespace App\Filament\Resources\Admins\Schemas;

use App\Models\Admin;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Admin')
                    ->icon('heroicon-o-identification')
                    ->description('Informasi utama mengenai admin.')
                    ->schema([

                        Group::make([

                            TextEntry::make('user.nama')
                                ->label('Nama Admin')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('user.email')
                                ->label('Email')
                                ->badge()
                                ->color('success')
                                ->placeholder('-'),

                            TextEntry::make('tipe_admin')
                                ->label('Tipe Admin')
                                ->badge()
                                ->color('warning')
                                ->placeholder('-'),

                        ])
                        ->columnSpan(2),

                        Group::make([

                            ImageEntry::make('user.foto')
                                ->label('Foto Profil')
                                ->placeholder('-'),

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
                                ->visible(fn (Admin $record): bool => $record->trashed()),

                        ])
                        ->columnSpan(1),

                    ])
                    ->columns(3)
                    ->columnSpanFull(),

            ]);
    }
}