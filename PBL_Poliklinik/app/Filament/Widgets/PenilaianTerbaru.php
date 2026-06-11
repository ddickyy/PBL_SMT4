<?php

namespace App\Filament\Widgets;

use App\Models\Penilaian;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class PenilaianTerbaru extends TableWidget
{
    protected static ?int $sort = 4;

    protected static ?string $heading = 'Penilaian & Feedback Terbaru';

    protected int|string|array $columnSpan = 'full';

    protected ?string $emptyStateHeading = 'Belum ada penilaian';

    protected ?string $emptyStateDescription = 'Penilaian dari pasien akan muncul di sini setelah mereka memberikan feedback';

    protected ?string $emptyStateIcon = 'heroicon-o-star';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Penilaian::query()
                    ->with(['reservasi.user', 'reservasi.jadwal.dokter.user'])
                    ->latest()
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('reservasi.user.nama')
                    ->label('Pasien')
                    ->searchable()
                    ->icon('heroicon-m-user')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('reservasi.jadwal.dokter.user.nama')
                    ->label('Dokter')
                    ->icon('heroicon-m-user-circle')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('reservasi.tanggal_reservasi')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->icon('heroicon-m-calendar')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('kritik')
                    ->label('Kritik')
                    ->limit(50)
                    ->tooltip(fn (string $state): string => $state),

                Tables\Columns\TextColumn::make('saran')
                    ->label('Saran')
                    ->limit(50)
                    ->tooltip(fn (string $state): string => $state),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diinput')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->striped();
    }
}
