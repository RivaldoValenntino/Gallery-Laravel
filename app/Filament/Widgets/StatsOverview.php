<?php

namespace App\Filament\Widgets;

use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = auth()->id();

        return [
            Stat::make('Photos', Photo::where('user_id', $userId)->count())
                ->description('Last 30 Days')
                ->descriptionIcon('heroicon-o-photo'),
            Stat::make('Albums', Album::where('user_id', $userId)->count())
                ->description('Last 30 Days')
                ->descriptionIcon('heroicon-o-rectangle-stack'),
        ];
    }
}
