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

    protected static ?string $navigationLabel = 'Keahlian';

    protected static ?string $slug = 'keahlian';

    protected static ?string $pluralLabel = 'Keahlian';

    protected static ?string $pluralSlug = 'keahlian';

    protected static ?string $label = 'Keahlian';

    protected static ?int $navigationSort = 4;

    protected static string $permission = 'spesialisasi';

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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if (
            $user->role?->nama_role === 'superadmin'
        ) {
            return true;
        }

        return $user->hasPermission(
            static::$permission
        );
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function canViewAny(): bool
    {
        return static::canAccess();
    }

    public static function canView($record): bool
    {
        return static::canAccess();
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }

    public static function canForceDelete($record): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }

    public static function canRestore($record): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }
}
