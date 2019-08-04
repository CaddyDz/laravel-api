<?php

namespace App\Providers;

use App\Mail\ChannelManager;
use Illuminate\Contracts\Notifications\Dispatcher as DispatcherContract;
use Illuminate\Notifications\NotificationServiceProvider as BaseProvider;

class NotificationServiceProvider extends BaseProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Don't publish anything
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ChannelManager::class, function ($app) {
            return new ChannelManager($app);
        });
        $this->app->alias(
            ChannelManager::class,
            DispatcherContract::class
        );
        $this->app->alias(
            ChannelManager::class,
            FactoryContract::class
        );
    }
}
