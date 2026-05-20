<?php

namespace App\Filament\Resources\KuotaHarians;

use App\Filament\Resources\KuotaHarians\Pages\CreateKuotaHarian;
use App\Filament\Resources\KuotaHarians\Pages\EditKuotaHarian;
use App\Filament\Resources\KuotaHarians\Pages\ListKuotaHarians;
use App\Filament\Resources\KuotaHarians\Pages\ViewKuotaHarian;
use App\Filament\Resources\KuotaHarians\Schemas\KuotaHarianForm;
use App\Filament\Resources\KuotaHarians\Schemas\KuotaHarianInfolist;
use App\Filament\Resources\KuotaHarians\Tables\KuotaHariansTable;
use App\Models\KuotaHarian;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class KuotaHarianResource extends Resource
{
    protected static ?string $model = KuotaHarian::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Calendar;

    protected static string|\UnitEnum|null $navigationGroup = 'Reservasi';

    protected static ?string $navigationLabel = 'Kuota Harian';

    protected static ?string $slug = 'kuota-harian';

    protected static ?string $pluralLabel = 'Kuota Harian';

    protected static ?string $pluralSlug = 'kuota-harian';

    protected static ?string $label = 'Kuota Harian';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return KuotaHarianForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KuotaHarianInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KuotaHariansTable::configure($table);
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
            'index' => ListKuotaHarians::route('/'),
            'create' => CreateKuotaHarian::route('/create'),
            'view' => ViewKuotaHarian::route('/{record}'),
            'edit' => EditKuotaHarian::route('/{record}/edit'),
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
}
