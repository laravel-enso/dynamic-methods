<?php

namespace LaravelEnso\DynamicMethods\Contracts;

use Closure;

interface DynamicMethods
{
    public static function resolveMethodUsing(string $name, Closure $method): void;
}
