<?php

namespace LaravelEnso\DynamicMethods;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\DynamicMethods\Services\Binder;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dynamics.php', 'enso.dynamics');

        $this->publishes([
            __DIR__.'/../config' => config_path('enso'),
        ], ['dynamics-config', 'enso-config']);

        (new Binder())->handle();
    }
}
