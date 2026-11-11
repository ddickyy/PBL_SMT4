<?php

namespace App\Filament\Resources\JadwalDokters;

use App\Filament\Resources\JadwalDokters\Pages\CreateJadwalDokter;
use App\Filament\Resources\JadwalDokters\Pages\EditJadwalDokter;
use App\Filament\Resources\JadwalDokters\Pages\ListJadwalDokters;
use App\Filament\Resources\JadwalDokters\Pages\ViewJadwalDokter;
use App\Filament\Resources\JadwalDokters\Schemas\JadwalDokterForm;
use App\Filament\Resources\JadwalDokters\Tables\JadwalDoktersTable;
use App\Filament\Resources\JadwalDokters\Schemas\JadwalDokterInfolist;
use App\Models\JadwalDokter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
// use App\Filament\Resources\JadwalDokters\RelationManagers\KuotaHarianRelationManager;

class JadwalDokterResource extends Resource
{
    protected static ?string $model = JadwalDokter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'dokter.user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Reservasi';

    protected static ?string $navigationLabel = 'Jadwal Dokter';

    protected static ?string $slug = 'jadwal-dokter';

    protected static ?string $pluralLabel = 'Jadwal Dokter';

    protected static ?string $pluralSlug = 'jadwal-dokter';

    protected static ?string $label = 'Jadwal Dokter';

    protected static ?int $navigationSort = 10;

    protected static string $permission = 'jadwal_dokter';

    public static function form(Schema $schema): Schema
    {
        return JadwalDokterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JadwalDoktersTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JadwalDokterInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            // KuotaHarianRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJadwalDokters::route('/'),
            'create' => CreateJadwalDokter::route('/create'),
            'view' => ViewJadwalDokter::route('/{record}'),
            'edit' => EditJadwalDokter::route('/{record}/edit'),
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
        return static::canAccess();
    }

    public static function canEdit($record): bool
    {
        return static::canAccess();
    }

    public static function canDelete($record): bool
    {
        return static::canAccess();
    }

    public static function canForceDelete($record): bool
    {
        return static::canAccess();
    }

    public static function canRestore($record): bool
    {
        return static::canAccess();
    }
}
