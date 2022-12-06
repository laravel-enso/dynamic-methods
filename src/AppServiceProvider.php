<?php

namespace LaravelEnso\DynamicMethods;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\Services\Websockets;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        'websockets' => Websockets::class,
    ];

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dynamics.php', 'enso.dynamics');

        $this->publishes([
            __DIR__.'/../config' => config_path('enso'),
        ], ['dynamics-config', 'enso-config']);
    }
}
