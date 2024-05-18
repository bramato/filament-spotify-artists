<?php

namespace Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages;

use Bramato\FilamentSpotifyManager\Resources\ArtistResource;
use Bramato\FilamentStripeManager\Resources\StripeProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArtist extends CreateRecord
{
    protected static string $resource = ArtistResource::class;
}
