<?php

namespace App\Filament\Resources\Tendiks;

use App\Filament\Resources\Tendiks\Pages\CreateTendik;
use App\Filament\Resources\Tendiks\Pages\EditTendik;
use App\Filament\Resources\Tendiks\Pages\ListTendiks;
use App\Filament\Resources\Tendiks\Pages\ViewTendik;
use App\Filament\Resources\Tendiks\Schemas\TendikForm;
use App\Filament\Resources\Tendiks\Schemas\TendikInfolist;
use App\Filament\Resources\Tendiks\Tables\TendiksTable;
use App\Models\Tendik;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TendikResource extends Resource
{
    protected static ?string $model = Tendik::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Briefcase;

    protected static ?string $recordTitleAttribute = 'user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Pasien';

    protected static ?string $navigationLabel = 'Tendik';

    protected static ?string $slug = 'tendik';

    protected static ?string $pluralLabel = 'Tendik';

    protected static ?string $pluralSlug = 'tendik';

    protected static ?string $label = 'Tendik';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return TendikForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TendikInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TendiksTable::configure($table);
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
            'index' => ListTendiks::route('/'),
            'create' => CreateTendik::route('/create'),
            'view' => ViewTendik::route('/{record}'),
            'edit' => EditTendik::route('/{record}/edit'),
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
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return in_array(
            $user->role?->nama_role,
            ['superadmin', 'admin']
        );
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    // Bisa melihat daftar data
    public static function canViewAny(): bool
    {
        return in_array(
            Auth::user()?->role?->nama_role,
            ['superadmin', 'admin']
        );
    }

    // Bisa melihat detail data
    public static function canView($record): bool
    {
        return in_array(
            Auth::user()?->role?->nama_role,
            ['superadmin', 'admin']
        );
    }

    // Hanya superadmin bisa create
    public static function canCreate(): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }

    // Hanya superadmin bisa edit
    public static function canEdit($record): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }

    // Hanya superadmin bisa delete
    public static function canDelete($record): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }

    // Hanya superadmin bisa force delete
    public static function canForceDelete($record): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }

    // Hanya superadmin bisa restore
    public static function canRestore($record): bool
    {
        return Auth::user()?->role?->nama_role
            === 'superadmin';
    }
}
