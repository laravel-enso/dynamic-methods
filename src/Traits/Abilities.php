<?php

namespace LaravelEnso\DynamicMethods\Traits;

use Closure;
use Illuminate\Support\Str;

trait Abilities
{
    protected static array $dynamicMethods = [];

    public function __call($method, $args)
    {
        if (isset(static::$dynamicMethods[$method])) {
            $params = [static::$dynamicMethods[$method], $this, static::class];
            $closure = Closure::bind(...$params);

            return $closure(...$args);
        }

        return parent::__call($method, $args);
    }

    public function hasNamedScope($scope)
    {
        return isset(static::$dynamicMethods['scope'.ucfirst($scope)])
            || parent::hasNamedScope($scope);
    }

    public function hasGetMutator($key)
    {
        return isset(static::$dynamicMethods['get'.Str::studly($key).'Attribute'])
            || parent::hasGetMutator($key);
    }

    public function hasSetMutator($key)
    {
        return isset(static::$dynamicMethods['set'.Str::studly($key).'Attribute'])
            || parent::hasSetMutator($key);
    }

    public static function addDynamicMethod($name, Closure $method): void
    {
        static::$dynamicMethods[$name] = $method;
    }
}
