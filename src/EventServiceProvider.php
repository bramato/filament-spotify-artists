<?php

namespace Bramato\FilamentStripeManager;

use Bramato\FilamentStripeManager\Events\BlogPublished;
use Bramato\FilamentStripeManager\Events\MetadataModelEvent;
use Bramato\FilamentStripeManager\Events\ProductModelEvent;
use Bramato\FilamentStripeManager\Events\StripeWebhookEvent;
use Bramato\FilamentStripeManager\Listeners\CheckStripeCustomer;
use Bramato\FilamentStripeManager\Listeners\MetadataModelListener;
use Bramato\FilamentStripeManager\Listeners\ProductModelListener;
use Bramato\FilamentStripeManager\Listeners\SendBlogPublishedNotification;
use Bramato\FilamentStripeManager\Listeners\StripeWebhookCallListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        StripeWebhookEvent::class => [
            StripeWebhookCallListener::class,
        ],
        Login::class =>[
            CheckStripeCustomer::class
        ],
        ProductModelEvent::class => [
            ProductModelListener::class
        ],
        MetadataModelEvent::class => [
            MetadataModelListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
