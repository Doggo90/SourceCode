<?php

namespace App\Filament\Resources\ReportsResource\Pages;

use App\Filament\Resources\ReportsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Models\User;
use App\Models\Post;
use App\Models\Reports;

class ListReports extends ListRecords
{
    protected static string $resource = ReportsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Users Reported' => Tab::make()
            ->modifyQueryUsing( function($query){
                $query->where('reportable_type', "App\Models\User");
            })->badge(Reports::query()->where('reportable_type', "App\Models\User")->count()),
            'Posts Reported' => Tab::make()
            ->modifyQueryUsing(function ($query) {
                $query->where('reportable_type', "App\Models\Post");
            })->badge(Reports::query()->where('reportable_type', "App\Models\Post")->count()),

        ];
    }
}
