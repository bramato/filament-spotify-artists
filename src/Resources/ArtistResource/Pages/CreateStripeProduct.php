<?php

namespace Bramato\FilamentStripeManager\Resources\StripeProductResource\Pages;

use Bramato\FilamentStripeManager\Resources\StripeProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStripeProduct extends CreateRecord
{
    protected static string $resource = StripeProductResource::class;
}
