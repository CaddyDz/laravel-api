<?php

namespace App\Providers;

use Laravel\Passport\Console;
use Laravel\Passport\PassportServiceProvider as BaseProvider;

class PassportServiceProvider extends BaseProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerMigrations();

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'passport-migrations');

            $this->commands([
                Console\InstallCommand::class,
                Console\ClientCommand::class,
                Console\KeysCommand::class,
            ]);
        }
    }
}
