<?php

namespace Bramato\FilamentSpotifyManager\Resources\AlbumResource\Pages;

use Bramato\FilamentSpotifyManager\Resources\AlbumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlbums extends ListRecords
{
    protected static string $resource = AlbumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
