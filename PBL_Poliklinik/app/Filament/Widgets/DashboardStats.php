<?php

namespace App\Filament\Widgets;

use App\Models\Dokter;
use App\Models\Reservasi;
use App\Models\RekamMedis;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $todayReservasi = Reservasi::whereDate('tanggal_reservasi', today())->count();
        $yesterdayReservasi = Reservasi::whereDate('tanggal_reservasi', now()->subDays(1))->count();
        $reservasiMenunggu = Reservasi::where('status', 'menunggu')->count();
        $reservasiSelesai = Reservasi::where('status', 'selesai')->count();

        $trend = $yesterdayReservasi > 0 
            ? (($todayReservasi - $yesterdayReservasi) / $yesterdayReservasi) * 100
            : 0;

        return [
                Stat::make(
                    'Total Reservasi',
                    Reservasi::count()
                )
                ->description(
                    $reservasiMenunggu . ' menunggu • '
                    . $reservasiSelesai . ' selesai'
                )
                ->color('primary')
                ->chart([
                    Reservasi::whereDate('tanggal_reservasi', now()->subDays(6))->count(),
                    Reservasi::whereDate('tanggal_reservasi', now()->subDays(5))->count(),
                    Reservasi::whereDate('tanggal_reservasi', now()->subDays(4))->count(),
                    Reservasi::whereDate('tanggal_reservasi', now()->subDays(3))->count(),
                    Reservasi::whereDate('tanggal_reservasi', now()->subDays(2))->count(),
                    Reservasi::whereDate('tanggal_reservasi', now()->subDays(1))->count(),
                    $todayReservasi,
                ]),

            Stat::make('Reservasi Menunggu', $reservasiMenunggu)
                ->description('Menunggu layanan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Reservasi Selesai', $reservasiSelesai)
                ->description('Sudah dilayani')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Dokter', Dokter::count())
                ->description('Dokter terdaftar')
                ->descriptionIcon('heroicon-m-user')
                ->color('info'),

            Stat::make('Rekam Medis', RekamMedis::count())
                ->description('Data pasien')
                ->descriptionIcon('heroicon-m-document')
                ->color('danger'),

            Stat::make('Total Pengguna', User::count())
                ->description('Semua pengguna sistem')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),
        ];
    }
}