<?php

namespace LaravelEnso\DynamicMethods\Traits;

use Illuminate\Support\Str;

trait Abilities
{
    use Methods;

    public function getRelationValue($key)
    {
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        if (isset(static::$dynamicMethods[$key]) || method_exists($this, $key)) {
            return $this->getRelationshipFromMethod($key);
        }
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
}
