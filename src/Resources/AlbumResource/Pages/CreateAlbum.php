<?php

namespace Bramato\FilamentSpotifyManager\Resources\AlbumResource\Pages;

use Bramato\FilamentSpotifyManager\Resources\AlbumResource;
use Bramato\FilamentStripeManager\Resources\StripeProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAlbum extends CreateRecord
{
    protected static string $resource = AlbumResource::class;
}
