<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            \App\Filament\Pages\Actions\ButtonLink::make('open-post-url')
            ->label(__('resources.post.open_post_url'))
                ->disabled(fn ($record) => !$record?->published_at)
                ->tooltip(__('Only published items can be viewed'))
                ->url(fn ($record) => \route('filament.resources.posts.show', $record->slug))
                ->openUrlInNewTab()
                ->icon('heroicon-o-external-link'),
        ];
    }
}
