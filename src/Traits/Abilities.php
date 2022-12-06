<?php

namespace LaravelEnso\DynamicMethods\Traits;

use Illuminate\Support\Str;

trait Abilities
{
    use Methods;

    public function hasNamedScope($scope)
    {
        $name = Str::of($scope)->ucfirst()->prepend('scope')->__toString();

        return isset(static::$methodResolvers[$name])
            || parent::hasNamedScope($scope);
    }

    public function hasGetMutator($key)
    {
        $name = Str::of($key)->studly()
            ->prepend('get')->append('Attribute')->__toString();

        return isset(static::$methodResolvers[$name])
            || parent::hasGetMutator($key);
    }

    public function hasSetMutator($key)
    {
        $name = Str::of($key)->studly()
            ->prepend('set')->append('Attribute')->__toString();

        return isset(static::$methodResolvers[$name])
            || parent::hasSetMutator($key);
    }
}
