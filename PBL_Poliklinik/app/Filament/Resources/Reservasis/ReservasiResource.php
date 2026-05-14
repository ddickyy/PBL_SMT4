<?php

namespace App\Filament\Resources\Reservasis;

use App\Filament\Resources\Reservasis\Pages\CreateReservasi;
use App\Filament\Resources\Reservasis\Pages\EditReservasi;
use App\Filament\Resources\Reservasis\Pages\ListReservasis;
use App\Filament\Resources\Reservasis\Pages\ViewReservasi;
use App\Filament\Resources\Reservasis\Schemas\ReservasiForm;
use App\Filament\Resources\Reservasis\Tables\ReservasisTable;
use App\Filament\Resources\Reservasis\Schemas\ReservasiInfolist;
use App\Models\Reservasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ReservasiResource extends Resource
{
    protected static ?string $model = Reservasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCheck;

    protected static ?string $recordTitleAttribute = 'user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Reservasi';

    protected static ?string $navigationLabel = 'Reservasi';

    protected static ?string $slug = 'reservasi';

    protected static ?string $pluralLabel = 'Reservasi';

    protected static ?string $pluralSlug = 'reservasi';

    protected static ?string $label = 'Reservasi';

    protected static ?int $navigationSort = 13;

    public static function form(Schema $schema): Schema
    {
        return ReservasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReservasisTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReservasiInfolist::configure($schema);
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
            'index' => ListReservasis::route('/'),
            'create' => CreateReservasi::route('/create'),
            'view' => ViewReservasi::route('/{record}'),
            'edit' => EditReservasi::route('/{record}/edit'),
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
