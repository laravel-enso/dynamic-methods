<?php

namespace LaravelEnso\DynamicMethods\app\Traits;

use Closure;
use BadMethodCallException;

trait Methods
{
    protected static $dynamicMethods = [];

    public static function addDynamicMethod($name, Closure $method)
    {
        static::$dynamicMethods[$name] = $method;
    }

    public function __call($method, $args)
    {
        if (isset(static::$dynamicMethods[$method])) {
            $closure = Closure::bind(
                static::$dynamicMethods[$method], $this, static::class
            );

            return $closure(...$args);
        }

        if (method_exists(parent::class, '__call')) {
            return parent::__call($method, $args);
        }

        throw new BadMethodCallException(
            'Method '.static::class.'::'.$method.'() not found'
        );
    }
}
