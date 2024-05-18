<?php

namespace Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages;

use Bramato\FilamentStripeManager\Resources\StripeProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtist extends EditRecord
{
    protected static string $resource = StripeProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
