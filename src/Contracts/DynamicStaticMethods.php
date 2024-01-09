<?php

namespace LaravelEnso\DynamicMethods\Contracts;

use Closure;

interface DynamicStaticMethods
{
    public static function resolveStaticMethodUsing(string $name, Closure $method);
}
