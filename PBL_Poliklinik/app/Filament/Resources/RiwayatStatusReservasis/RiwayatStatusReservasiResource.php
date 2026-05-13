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
            'create' => CreateRiwayatStatusReservasi::route('/create'),
            'view' => ViewRiwayatStatusReservasi::route('/{record}'),
            'edit' => EditRiwayatStatusReservasi::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
