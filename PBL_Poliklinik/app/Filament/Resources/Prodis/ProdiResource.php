<?php

namespace App\Filament\Resources\Prodis;

use App\Filament\Resources\Prodis\Pages\CreateProdi;
use App\Filament\Resources\Prodis\Pages\EditProdi;
use App\Filament\Resources\Prodis\Pages\ListProdis;
use App\Filament\Resources\Prodis\Schemas\ProdiForm;
use App\Filament\Resources\Prodis\Tables\ProdisTable;
use App\Models\Prodi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdiResource extends Resource
{
    protected static ?string $model = Prodi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'nama_prodi';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Prodi';

    protected static ?string $slug = 'prodi';

    protected static ?string $pluralLabel = 'Prodi';

    protected static ?string $pluralSlug = 'prodi';

    protected static ?string $label = 'Prodi';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return ProdiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProdisTable::configure($table);
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
            'index' => ListProdis::route('/'),
            'create' => CreateProdi::route('/create'),
            'edit' => EditProdi::route('/{record}/edit'),
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
