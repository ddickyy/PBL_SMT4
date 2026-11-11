<?php

namespace App\Filament\Widgets;

use App\Models\JadwalDokter;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class JadwalDokterHariIni extends TableWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Jadwal Dokter Hari Ini';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    protected ?string $emptyStateHeading = 'Tidak ada jadwal hari ini';

    protected ?string $emptyStateDescription = 'Tidak ada dokter yang jadwal praktik hari ini';

    protected ?string $emptyStateIcon = 'heroicon-o-calendar-days';

    public function table(Table $table): Table
    {
        $today = now()->format('Y-m-d');
        $dayName = now()->format('l');
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $hari = $dayMap[$dayName] ?? $dayName;

        return $table
            ->query(
                JadwalDokter::query()
                    ->with(['dokter.user', 'dokter.spesialisasi', 'reservasi' => function ($query) use ($today) {
                        $query->whereDate('tanggal_reservasi', $today);
                    }])
                    ->where('hari', $hari)
                    ->where('aktif', true)
                    ->orderBy('jam_mulai')
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('dokter.user.nama')
                    ->label('Dokter')
                    ->searchable()
                    ->icon('heroicon-m-user')
                    ->iconPosition('before')
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('dokter.spesialisasi.nama_spesialisasi')
                    ->label('Spesialisasi')
                    ->icon('heroicon-m-briefcase')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->time('H:i')
                    ->icon('heroicon-m-clock')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('reservasi_count')
                    ->label('Pasien Hari Ini')
                    ->counts('reservasi')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-users')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('kuota_maksimal')
                    ->label('Kuota')
                    ->badge()
                    ->color('success'),
            ])
            ->striped();
    }
}
