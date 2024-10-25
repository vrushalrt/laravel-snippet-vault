<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
//        $startDate = $this->filters['startDate'];
//        $endDate = $this->filters['endDate'];
        return [
            Stat::make('New Users', User::count())
                ->description('New users that have joined.')
                ->descriptionIcon('heroicon-s-user', IconPosition::Before)
                ->chart([0,2,5,8,10,20,40,10,40,500,1500,5000,7000,10000,120])
                ->color('info'),
        ];

//        return [
//            Stat::make('New Users',
//                User::
//                    when($startDate,
//                        fn ($query) => $query->whereDate('created_at', '>', $startDate))
//                    ->when($endDate,
//                        fn ($query) => $query->whereDate('created_at', '<', $endDate))
//                    ->count()
//                    )
//                ->description('New users that have joined.')
//                ->descriptionIcon('heroicon-s-user', IconPosition::Before)
//                ->chart([0,2,5,8,10,20,40,10,40,500,1500,5000,7000,10000,120])
//                ->color('info'),
//        ];

    }
}
