<?php

namespace App\Filament\Widgets;

use App\Models\Reservasi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class UnseenMonthlyChart extends ChartWidget
{
    protected int|string|array $columnSpan = 'full';
    protected ?string $heading = 'Jumlah Reservasi Bulan Ini';

    protected function getData(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $labels = [];
        $reservasiData = [];

        for ($day = 1; $day <= $endOfMonth->day; $day++) {
            $date = $startOfMonth->copy()->addDays($day - 1);
            
            $labels[] = $date->format('d');

            $reservasiData[] = Reservasi::whereDate('tanggal_reservasi', $date->toDateString())
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Reservasi',
                    'data' => $reservasiData,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#1e40af',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
