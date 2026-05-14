<?php

namespace App\Filament\Resources\Dokters\RelationManagers;

use App\Filament\Resources\JadwalDokters\JadwalDokterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class JadwalDokterRelationManager extends RelationManager
{
    protected static string $relationship = 'jadwalDokter';

    protected static ?string $relatedResource = JadwalDokterResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
