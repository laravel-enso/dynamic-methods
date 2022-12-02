<?php

namespace LaravelEnso\DynamicMethods\Services;

use Illuminate\Support\Collection;

class Dynamics
{
    public static function bind(string $model, string | array $dynamics): void
    {
        Collection::wrap($dynamics)
            ->each(fn ($dynamic) => (new Dynamic(new $model(), new $dynamic()))
                ->bind());
    }
}
