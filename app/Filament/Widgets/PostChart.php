<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use App\Models\Post;

class PostChart extends ChartWidget
{
    protected static ?int $sort = 3;

    // protected int | string | array $columnSpan = 'full';
    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected static ?string $maxHeight = '300px';

    protected static ?string $heading = 'Posts per Month';

    protected function getData(): array
    {
        $data = $this->getPostsPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'Posts Created',

                    'data' => $data['postsPerMonth'],
                ],
            ],
            'labels' => $data['months'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getPostsPerMonth(): array
    {
        $now = Carbon::now();

        $postsPerMonth = [];
        $months = collect(range(1, 12))
            ->map(function ($month) use ($now, &$postsPerMonth) {
                // Get the first day of the given month in the current year
                $monthStart = Carbon::parse($now->year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01');

                // Count the posts for this month
                $count = Post::whereMonth('created_at', $monthStart->month)
                    ->whereYear('created_at', $monthStart->year)
                    ->count();

                // Store the count in the postsPerMonth array
                $postsPerMonth[] = $count;

                // Return the month name
                return $monthStart->format('M');
            })
            ->toArray();

        return [
            'postsPerMonth' => $postsPerMonth,
            'months' => $months,
        ];
    }
}
