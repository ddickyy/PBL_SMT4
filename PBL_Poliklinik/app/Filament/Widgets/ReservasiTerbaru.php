<?php

namespace App\Filament\Widgets;

use App\Models\Reservasi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class ReservasiTerbaru extends TableWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Reservasi Terbaru';

    protected int|string|array $columnSpan = 'full';

    protected ?string $emptyStateHeading = 'Belum ada reservasi';

    protected ?string $emptyStateDescription = 'Menunggu pasien untuk melakukan reservasi layanan kesehatan';

    protected ?string $emptyStateIcon = 'heroicon-o-calendar';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Reservasi::query()
                    ->with(['user', 'jadwal.dokter.user', 'jadwal.dokter.spesialisasi'])
                    ->latest('tanggal_reservasi')
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('user.nama')
                    ->label('Pasien')
                    ->searchable()
                    ->icon('heroicon-m-user')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('tanggal_reservasi')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-m-calendar')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('jadwal.dokter.user.nama')
                    ->label('Dokter')
                    ->icon('heroicon-m-user-circle')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('nomor_antrian')
                    ->label('Antrian')
                    ->badge()
                    ->color('info'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'menunggu',
                        'success' => 'selesai',
                        'danger' => 'dibatalkan',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->striped();
    }
}