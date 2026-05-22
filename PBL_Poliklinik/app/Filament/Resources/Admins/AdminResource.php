<?php

namespace App\Filament\Resources\Admins;

use App\Filament\Resources\Admins\Pages\CreateAdmin;
use App\Filament\Resources\Admins\Pages\EditAdmin;
use App\Filament\Resources\Admins\Pages\ListAdmins;
use App\Filament\Resources\Admins\Pages\ViewAdmin;
use App\Filament\Resources\Admins\Schemas\AdminForm;
use App\Filament\Resources\Admins\Schemas\AdminInfolist;
use App\Filament\Resources\Admins\Tables\AdminsTable;
use App\Models\Admin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::WrenchScrewdriver;

    protected static ?string $recordTitleAttribute = 'user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengelola';

    protected static ?string $navigationLabel = 'Admin';

    protected static ?string $slug = 'admin';

    protected static ?string $pluralLabel = 'Admin';

    protected static ?string $pluralSlug = 'admin';

    protected static ?string $label = 'admin';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return AdminForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AdminInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminsTable::configure($table);
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
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'view' => ViewAdmin::route('/{record}'),
            'edit' => EditAdmin::route('/{record}/edit'),
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
