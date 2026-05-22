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
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\Dokters\RelationManagers\JadwalDokterRelationManager;

class DokterResource extends Resource
{
    protected static ?string $model = Dokter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Pencil;

    protected static ?string $recordTitleAttribute = 'user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengelola';

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
            JadwalDokterRelationManager::class,
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

    /*
    |--------------------------------------------------------------------------
    | READ ONLY FOR ADMIN
    |--------------------------------------------------------------------------
    */

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