<?php

namespace LaravelEnso\DynamicMethods\Traits;

use BadMethodCallException;
use Closure;

trait StaticMethods
{
    protected static $staticMethodResolvers = [];

    public static function __callStatic($method, $args)
    {
        if ($resolver = static::$staticMethodResolvers[$method] ?? null) {
            $closure = Closure::bind($resolver, null, static::class);

            return $closure(...$args);
        }

        if (method_exists(parent::class, '__callStatic')) {
            return parent::__callStatic($method, $args);
        }

        throw new BadMethodCallException(
            'Static method '.static::class.'::'.$method.'() not found'
        );
    }

    public static function resolveStaticMethodUsing(string $name, Closure $method)
    {
        static::$staticMethodResolvers[$name] = $method;
    }
}
