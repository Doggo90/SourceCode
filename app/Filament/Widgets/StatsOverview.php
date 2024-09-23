<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Post;

class StatsOverview extends BaseWidget
{
    // protected int | string | array $columnSpan = 'full';
    // protected int | string | array $columnSpan = [
    //     'md' => 2,
    //     'xl' => 3,
    // ];
    protected function getStats(): array
    {

        return [
            Stat::make('Users', User::all()->count()),
            Stat::make('Suspended Users', User::query()->where('is_suspended', 1)->count()),
            Stat::make('Posts', Post::all()->count()),
            Stat::make('Pending Posts', Post::query()->where('is_approved', 0)->count()),
            // ->description('32k increase')
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
            // Stat::make('Announcements', '1023232'),
        ];
    }
}
