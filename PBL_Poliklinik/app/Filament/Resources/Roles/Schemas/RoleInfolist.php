<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Models\Role;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Utama')
                    ->icon('heroicon-o-identification')
                    ->description('Informasi utama mengenai role.')
                    ->schema([

                        Group::make([
                            TextEntry::make('nama_role')
                                ->label('Nama Role')
                                ->badge()
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('deskripsi')
                                ->label('Deskripsi')
                                ->placeholder('Tidak ada deskripsi.')
                                ->markdown(),

                            TextEntry::make('permissions.nama_permission')
                                ->label('Hak Akses Menu')
                                ->badge()
                                ->separator(',')
                                ->color('success'),
                        ])
                        ->columnSpan(2),

                        Group::make([
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
                                ->visible(fn (Role $record): bool => $record->trashed()),

                        ])
                        ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
            ]);
    }
}