<?php

namespace App\Providers;

use App\Providers\ResponseFactory;
use Illuminate\Routing\RoutingServiceProvider as BaseProvider;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

class RoutingServiceProvider extends BaseProvider
{
    /**
     * Register the response factory implementation.
     *
     * @return void
     */
    protected function registerResponseFactory()
    {
        $this->app->singleton(ResponseFactoryContract::class, function ($app) {
            return new ResponseFactory($app['redirect']);
        });
    }
}
