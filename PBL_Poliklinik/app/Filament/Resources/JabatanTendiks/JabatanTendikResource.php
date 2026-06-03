<?php

namespace App\Filament\Resources\JabatanTendiks;

use App\Filament\Resources\JabatanTendiks\Pages\CreateJabatanTendik;
use App\Filament\Resources\JabatanTendiks\Pages\EditJabatanTendik;
use App\Filament\Resources\JabatanTendiks\Pages\ListJabatanTendiks;
use App\Filament\Resources\JabatanTendiks\Schemas\JabatanTendikForm;
use App\Filament\Resources\JabatanTendiks\Tables\JabatanTendiksTable;
use App\Models\JabatanTendik;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class JabatanTendikResource extends Resource
{
    protected static ?string $model = JabatanTendik::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'nama_jabatan';

    protected static string|\UnitEnum|null $navigationGroup = 'Status';

    protected static ?string $navigationLabel = 'Jabatan Tendik';

    protected static ?string $slug = 'jabatan-tendik';

    protected static ?string $pluralLabel = 'Jabatan Tendik';

    protected static ?string $pluralSlug = 'jabatan-tendik';

    protected static ?string $label = 'Jabatan Tendik';

    protected static ?int $navigationSort = 5;

    protected static string $permission = 'jabatan_tendik';

    public static function form(Schema $schema): Schema
    {
        return JabatanTendikForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JabatanTendiksTable::configure($table);
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
            'index' => ListJabatanTendiks::route('/'),
            'create' => CreateJabatanTendik::route('/create'),
            'edit' => EditJabatanTendik::route('/{record}/edit'),
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