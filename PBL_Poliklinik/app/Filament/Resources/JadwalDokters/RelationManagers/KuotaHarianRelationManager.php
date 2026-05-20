<?php

namespace App\Filament\Resources\JadwalDokters\RelationManagers;

use App\Filament\Resources\KuotaHarians\Schemas\KuotaHarianFormWithJadwal;
use App\Filament\Resources\KuotaHarians\Tables\KuotaHariansTable;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Schemas\Schema;
use Filament\Tables\Table;

class KuotaHarianRelationManager extends RelationManager
{
    protected static string $relationship = 'kuotaHarian';

    protected static ?string $title = 'Kuota Harian';

    public function form(Schema $schema): Schema
    {
        return KuotaHarianFormWithJadwal::configure($schema);
    }

    public function table(Table $table): Table
    {
        return KuotaHariansTable::configure($table)
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}