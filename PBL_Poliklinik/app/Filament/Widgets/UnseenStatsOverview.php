<?php

namespace App\Filament\Widgets;

use App\Models\Dokter;
use App\Models\Penilaian;
use App\Models\Reservasi;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UnseenStatsOverview extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';
    protected ?string $heading = 'Ringkasan Dashboard';

    protected function getCards(): array
    {
        return [
            Stat::make('Reservasi belum dilihat', Reservasi::where('viewed', false)->count())
                ->description('Reservasi baru yang belum dibuka oleh admin')
                ->color('warning')
                ->url('/admin/reservasi'),

            Stat::make('Penilaian belum dilihat', Penilaian::where('viewed', false)->count())
                ->description('Feedback yang belum diperiksa')
                ->color('info')
                ->url('/admin/penilaian'),

            Stat::make('Total Pasien Terdaftar', User::whereHas('role', fn ($query) => $query->where('nama_role', 'pasien'))->count())
                ->description('Jumlah pasien terdaftar')
                ->color('primary')
                ->url('/admin/users'),

            Stat::make('Dokter Aktif', Dokter::whereHas('jadwalDokter', fn ($query) => $query->where('aktif', true))->count())
                ->description('Dokter dengan jadwal aktif')
                ->color('success')
                ->url('/admin/dokter'),
        ];
    }
}
