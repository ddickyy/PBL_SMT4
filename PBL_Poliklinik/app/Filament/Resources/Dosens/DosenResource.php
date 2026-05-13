<?php

namespace App\Filament\Resources\Dosens;

use App\Filament\Resources\Dosens\Pages\CreateDosen;
use App\Filament\Resources\Dosens\Pages\EditDosen;
use App\Filament\Resources\Dosens\Pages\ListDosens;
use App\Filament\Resources\Dosens\Pages\ViewDosen;
use App\Filament\Resources\Dosens\Schemas\DosenForm;
use App\Filament\Resources\Dosens\Schemas\DosenInfolist;
use App\Filament\Resources\Dosens\Tables\DosensTable;
use App\Models\Dosen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DosenResource extends Resource
{
    protected static ?string $model = Dosen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::FaceSmile;

    protected static ?string $recordTitleAttribute = 'user.nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Pasien';

    protected static ?string $navigationLabel = 'Dosen';

    protected static ?string $slug = 'dosen';

    protected static ?string $pluralLabel = 'Dosen';

    protected static ?string $pluralSlug = 'dosen';

    protected static ?string $label = 'Dosen';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return DosenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DosenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DosensTable::configure($table);
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
            'index' => ListDosens::route('/'),
            'create' => CreateDosen::route('/create'),
            'view' => ViewDosen::route('/{record}'),
            'edit' => EditDosen::route('/{record}/edit'),
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
