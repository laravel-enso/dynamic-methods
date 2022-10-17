<?php

namespace LaravelEnso\DynamicMethods\Contracts;

use Closure;

interface Abilities
{
    public static function addDynamicMethod($name, Closure $method);
}
