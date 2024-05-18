<?php

namespace Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages;

use Bramato\FilamentSpotifyManager\Resources\ArtistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtists extends ListRecords
{
    protected static string $resource = ArtistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
