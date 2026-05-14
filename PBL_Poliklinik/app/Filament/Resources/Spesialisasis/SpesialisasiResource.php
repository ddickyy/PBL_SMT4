<?php

namespace App\Filament\Resources\Spesialisasis;

use App\Filament\Resources\Spesialisasis\Pages\CreateSpesialisasi;
use App\Filament\Resources\Spesialisasis\Pages\EditSpesialisasi;
use App\Filament\Resources\Spesialisasis\Pages\ListSpesialisasis;
use App\Filament\Resources\Spesialisasis\Schemas\SpesialisasiForm;
use App\Filament\Resources\Spesialisasis\Tables\SpesialisasisTable;
use App\Models\Spesialisasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SpesialisasiResource extends Resource
{
    protected static ?string $model = Spesialisasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::PuzzlePiece;

    protected static ?string $recordTitleAttribute = 'nama_spesialisasi';

    protected static string|\UnitEnum|null $navigationGroup = 'Status';

    protected static ?string $navigationLabel = 'Spesialisasi';

    protected static ?string $slug = 'spesialisasi';

    protected static ?string $pluralLabel = 'Spesialisasi';

    protected static ?string $pluralSlug = 'spesialisasi';

    protected static ?string $label = 'Spesialisasi';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return SpesialisasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpesialisasisTable::configure($table);
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
            'index' => ListSpesialisasis::route('/'),
            'create' => CreateSpesialisasi::route('/create'),
            'edit' => EditSpesialisasi::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role->nama_role === 'superadmin';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }
}
