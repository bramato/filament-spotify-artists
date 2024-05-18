<?php

namespace Bramato\FilamentStripeManager\Resources\StripeProductResource\Pages;

use Bramato\FilamentStripeManager\Resources\StripeProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStripeProducts extends ListRecords
{
    protected static string $resource = StripeProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
