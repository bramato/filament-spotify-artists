<?php

namespace Bramato\FilamentSpotifyManager;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSpotifyManagerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-stripe-manager')
            ->hasMigrations([
                '2024_04_24_075328_update_user_col',
                '2024_04_24_075329_create_stripe_webhook_calls_table',
                '2024_04_24_121801_create_stripe_payments_table',
                '2024_04_26_063441_create_stripe_payment_intents_table',
                '2024_04_26_063735_create_stripe_charges_table',
                '2024_04_26_153835_create_stripe_refund_table',
                '2024_04_26_165215_create_stripe_invoices_table',
                '2024_04_26_165216_create_stripe_invoice_lines_table',
                '2024_04_26_205121_create_stripe_subscriptions_table',
                '2024_04_26_205122_create_stripe_subscription_items_table',
                'create_stripe_product_table',
                'create_stripe_plan_table',
                'create_stripe_metadatamorph_table',
                'create_stripe_product_table_add_plan_id'
            ])
            ->hasTranslations()
        ->hasViews()
        ->hasRoute('web');
    }

    public function bootingPackage()
    {
        parent::bootingPackage();
        $this->registerLivewireComponents();
        $this->app->register(EventServiceProvider::class);
        $this->loadTestingMigrations();
        $this->loadTranslations();
    }

    protected function registerLivewireComponents()
    {
        // Replace 'ComponentClass' with the actual full class name of your Livewire component
        //Livewire::component('credit-card-payment', CreditCardPayment::class);
        // Register other components similarly
    }

    protected function loadTestingMigrations(): void
    {
        if ($this->app->environment('testing')) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-spotify-manager');
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/filament-spotify-manager'),
        ], 'lang');
    }
}
