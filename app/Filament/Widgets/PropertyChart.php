<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use Filament\Widgets\ChartWidget;

class PropertyChart extends ChartWidget
{
    protected static ?string $heading = 'Évolution des propriétés ajoutées';

    protected function getData(): array
    {
        $data = Property::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Propriétés ajoutées',
                    'data' => array_values($data),
                ],
            ],
            'labels' => array_map(fn($m) => date('F', mktime(0, 0, 0, $m, 10)), array_keys($data)),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
