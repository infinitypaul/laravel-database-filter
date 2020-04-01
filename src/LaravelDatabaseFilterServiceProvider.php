<?php

namespace Infinitypaul\LaravelDatabaseFilter;

use Illuminate\Support\ServiceProvider;
use Infinitypaul\LaravelDatabaseFilter\Console\CreateNewFilter;

class LaravelDatabaseFilterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {

             // Registering package commands.
             $this->commands([
                 CreateNewFilter::class
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {

    }
}
