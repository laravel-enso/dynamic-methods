<?php

namespace LaravelEnso\DynamicMethods\Traits;

use BadMethodCallException;
use Closure;

trait Methods
{
    protected static array $methodResolvers = [];

    public function __call($method, $args)
    {
        if ($resolver = static::$methodResolvers[$method] ?? null) {
            $closure = Closure::bind($resolver, $this, static::class);

            return $closure(...$args);
        }

        if (method_exists(parent::class, '__call')) {
            return parent::__call($method, $args);
        }

        throw new BadMethodCallException(
            'Method '.static::class.'::'.$method.'() not found'
        );
    }

    public static function resolveMethodUsing(string $name, Closure $method): void
    {
        static::$methodResolvers[$name] = $method;
    }
}
