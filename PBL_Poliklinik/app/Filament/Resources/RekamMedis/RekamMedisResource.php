<?php

namespace App\Filament\Resources\RekamMedis;

use App\Filament\Resources\RekamMedis\Pages\CreateRekamMedis;
use App\Filament\Resources\RekamMedis\Pages\EditRekamMedis;
use App\Filament\Resources\RekamMedis\Pages\ListRekamMedis;
use App\Filament\Resources\RekamMedis\Pages\ViewRekamMedis;
use App\Filament\Resources\RekamMedis\Schemas\RekamMedisForm;
use App\Filament\Resources\RekamMedis\Tables\RekamMedisTable;
use App\Filament\Resources\RekamMedis\Schemas\RekamMedisInfolist;
use App\Models\RekamMedis;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RekamMedisResource extends Resource
{
    protected static ?string $model = RekamMedis::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentMagnifyingGlass;

    protected static ?string $recordTitleAttribute = 'reservasi.user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Reservasi';

    protected static ?string $navigationLabel = 'Rekam Medis';

    protected static ?string $slug = 'rekam-medis';

    protected static ?string $pluralLabel = 'Rekam Medis';

    protected static ?string $pluralSlug = 'rekam-medis';

    protected static ?string $label = 'Rekam Medis';

    protected static ?int $navigationSort = 12;

    protected static string $permission = 'rekam_medis';

    public static function form(Schema $schema): Schema
    {
        return RekamMedisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RekamMedisTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RekamMedisInfolist::configure($schema);
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
            'index' => ListRekamMedis::route('/'),
            'create' => CreateRekamMedis::route('/create'),
            'view' => ViewRekamMedis::route('/{record}'),
            'edit' => EditRekamMedis::route('/{record}/edit'),
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
            $user->role?->nama_role === 'superadmin' || $user->role?->nama_role === 'admin'
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
