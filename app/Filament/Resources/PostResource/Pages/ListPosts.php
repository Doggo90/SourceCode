<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use App\Models\Post;
use Filament\Resources\Pages\ListRecords;
// use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Resources\Components\Tab;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

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
            'Approved Posts' => Tab::make()->modifyQueryUsing( function($query){
                $query->where('is_approved', 1);
            }),
            'Archived' => Tab::make()
            ->modifyQueryUsing( function($query){
                $query->where('is_archived', 1);
            })->badge(Post::query()->where('is_archived', 1)->count()),
            'Pending Posts' => Tab::make()->modifyQueryUsing( function($query){
                $query->where('is_approved', 0);
            })->badge(Post::query()->where('is_approved', 0)->count()),

        ];
    }
}
