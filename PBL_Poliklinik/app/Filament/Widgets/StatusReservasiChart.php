<?php

namespace App\Filament\Widgets;

use App\Models\Reservasi;
use Filament\Widgets\ChartWidget;

class StatusReservasiChart extends ChartWidget
{
    protected static ?int $sort = 6;

    protected ?string $heading = 'Distribusi Status Reservasi';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    protected function getData(): array
    {
        $menunggu = Reservasi::where('status', 'menunggu')->count();
        $selesai = Reservasi::where('status', 'selesai')->count();
        $dibatalkan = Reservasi::where('status', 'dibatalkan')->count();
        $total = $menunggu + $selesai + $dibatalkan;

        $persenMenunggu = $total > 0 ? round(($menunggu / $total) * 100, 1) : 0;
        $persenSelesai = $total > 0 ? round(($selesai / $total) * 100, 1) : 0;
        $persenDibatalkan = $total > 0 ? round(($dibatalkan / $total) * 100, 1) : 0;

        return [
            'datasets' => [
                [
                    'data' => [$menunggu, $selesai, $dibatalkan],
                    'backgroundColor' => [
                        '#eab308', // Kuning untuk Menunggu
                        '#10b981', // Hijau untuk Selesai
                        '#ef4444', // Merah untuk Dibatalkan
                    ],
                    'borderColor' => ['#fff', '#fff', '#fff'],
                    'borderWidth' => 2,
                    'hoverBorderWidth' => 3,
                ],
            ],
            'labels' => [
                "Menunggu ({$menunggu}) {$persenMenunggu}%",
                "Selesai ({$selesai}) {$persenSelesai}%",
                "Dibatalkan ({$dibatalkan}) {$persenDibatalkan}%",
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 15,
                        'font' => [
                            'size' => 12,
                            'weight' => '500',
                        ],
                    ],
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.label; }',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}