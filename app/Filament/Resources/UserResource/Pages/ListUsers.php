<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Models\User;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

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
            'Suspended Users' => Tab::make()
            ->modifyQueryUsing( function($query){
                $query->where('is_suspended', 1);
            })->badge(User::query()->where('is_suspended', 1)->count()),

        ];
    }
}
