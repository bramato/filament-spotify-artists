<?php

declare(strict_types=1);

namespace Bramato\FilamentStripeManager;

use BezhanSalleh\FilamentShield\Support\Utils;
use Bramato\FilamentStripeManager\Pages\PaymentHistory;
use Bramato\FilamentStripeManager\Pages\PaymentMethod;
use Bramato\FilamentStripeManager\Pages\Subscription;
use Bramato\FilamentStripeManager\Resources\StripeProductResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentStripeManagerCustomerPlugin implements Plugin
{

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-stripe-manager-customer';
    }

    public function register(Panel $panel): void
    {

            $panel->resources([
               //StripeProductResource::class,
            ])
                ->pages([
                    PaymentMethod::class,
                    PaymentHistory::class,
                    Subscription::class
                ])
            ;

    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
