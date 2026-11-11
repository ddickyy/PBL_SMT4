<?php

namespace App\Filament\Widgets;

use App\Models\Reservasi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ReservasiChart extends ChartWidget
{
    protected static ?int $sort = 5;

    protected ?string $heading = 'Grafik Reservasi 12 Bulan Terakhir';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $totalReservasi = 0;

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = Reservasi::whereYear('tanggal_reservasi', $month->year)
                ->whereMonth('tanggal_reservasi', $month->month)
                ->count();
            $data[] = $count;
            $labels[] = $month->format('M Y');
            $totalReservasi += $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Reservasi: ' . $totalReservasi,
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#3b82f6',
                    'pointBorderColor' => '#ffffff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'backgroundColor' => 'rgba(0,0,0,0.8)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 1,
                    'padding' => 10,
                    'displayColors' => true,
                    'callbacks' => [
                        'label' => 'function(context) { return "Reservasi: " + context.parsed.y + " data"; }',
                    ],
                ],
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 15,
                        'font' => [
                            'size' => 12,
                            'weight' => '500',
                        ],
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}