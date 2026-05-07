<?php

namespace App\Filament\Resources\Dokters;

use App\Filament\Resources\Dokters\Pages\CreateDokter;
use App\Filament\Resources\Dokters\Pages\EditDokter;
use App\Filament\Resources\Dokters\Pages\ListDokters;
use App\Filament\Resources\Dokters\Pages\ViewDokter;
use App\Filament\Resources\Dokters\Schemas\DokterForm;
use App\Filament\Resources\Dokters\Schemas\DokterInfolist;
use App\Filament\Resources\Dokters\Tables\DoktersTable;
use App\Models\Dokter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DokterResource extends Resource
{
    protected static ?string $model = Dokter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Pencil;

    protected static ?string $recordTitleAttribute = 'user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Personalitas';

    protected static ?string $navigationLabel = 'Dokter';

    protected static ?string $slug = 'dokter';

    protected static ?string $pluralLabel = 'Dokter';

    protected static ?string $pluralSlug = 'dokter';

    protected static ?string $label = 'Dokter';

    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
    {
        return DokterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DokterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoktersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDokters::route('/'),
            'create' => CreateDokter::route('/create'),
            'view' => ViewDokter::route('/{record}'),
            'edit' => EditDokter::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
