<?php

namespace Bramato\FilamentSpotifyManager\Resources\AlbumResource\Pages;

use Bramato\FilamentStripeManager\Resources\StripeProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlbum extends EditRecord
{
    protected static string $resource = StripeProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
