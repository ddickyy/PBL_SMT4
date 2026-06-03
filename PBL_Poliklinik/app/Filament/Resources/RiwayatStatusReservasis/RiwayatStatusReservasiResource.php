<?php

namespace App\Filament\Resources\RiwayatStatusReservasis;

use App\Filament\Resources\RiwayatStatusReservasis\Pages\CreateRiwayatStatusReservasi;
use App\Filament\Resources\RiwayatStatusReservasis\Pages\EditRiwayatStatusReservasi;
use App\Filament\Resources\RiwayatStatusReservasis\Pages\ListRiwayatStatusReservasis;
use App\Filament\Resources\RiwayatStatusReservasis\Pages\ViewRiwayatStatusReservasi;
use App\Filament\Resources\RiwayatStatusReservasis\Schemas\RiwayatStatusReservasiForm;
use App\Filament\Resources\RiwayatStatusReservasis\Schemas\RiwayatStatusReservasiInfolist;
use App\Filament\Resources\RiwayatStatusReservasis\Tables\RiwayatStatusReservasisTable;
use App\Models\RiwayatStatusReservasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RiwayatStatusReservasiResource extends Resource
{
    protected static ?string $model = RiwayatStatusReservasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'reservasi.user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Reservasi';

    protected static ?string $navigationLabel = 'Riwayat Reservasi';

    protected static ?string $slug = 'riwayat-status-reservasi';

    protected static ?string $pluralLabel = 'Riwayat Reservasi';

    protected static ?string $pluralSlug = 'riwayat-reservasi';

    protected static ?string $label = 'Riwayat Reservasi';

    protected static ?int $navigationSort = 12;

    protected static string $permission = 'riwayat_reservasi';

    public static function form(Schema $schema): Schema
    {
        return RiwayatStatusReservasiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RiwayatStatusReservasiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiwayatStatusReservasisTable::configure($table);
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
            'index' => ListRiwayatStatusReservasis::route('/'),
            // 'create' => CreateRiwayatStatusReservasi::route('/create'),
            'view' => ViewRiwayatStatusReservasi::route('/{record}'),
            // 'edit' => EditRiwayatStatusReservasi::route('/{record}/edit'),
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
