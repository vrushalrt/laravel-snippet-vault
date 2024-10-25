<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class TestChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'];
        $endDate = $this->filters['endDate'];

        $data = Trend::model(User::class)
        ->between(
            start: $startDate ? Carbon::parse($startDate) :  now()->subMonth(3),
            end: $endDate ? Carbon::parse($endDate) :now(),
        )
        ->perMonth()
        ->count();

        // return [
        //     'datasets' => [
        //         [
        //             'label' => 'Blog posts created',
        //             'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
        //             'borderColor'=> 'rgb(75, 192, 192)',
        //         ],
        //         [
        //             'label' => 'Blog posts Deleted',
        //             'data' => [0, 0, 0, 0, 210, 320, 450, 740, 40, 45, 70, 80],
        //             'borderColor'=> 'rgb(255, 0, 0)',
        //         ],
        //     ],

        //     'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        // ];

        return [
            'datasets' => [
                [
                    'label' => 'Users Sign up.',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
