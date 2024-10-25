<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Components\Tab as ComponentsTab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

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
            'All' => ComponentsTab::make(),    
            'Published' => ComponentsTab::make()->modifyQueryUsing(function (EloquentBuilder $query) {
                $query->where('published', true);
                }),
            'Un Published' => ComponentsTab::make()->modifyQueryUsing(function (EloquentBuilder $query) {
                $query->where('published', false);
            })    
        ];
    }
}
