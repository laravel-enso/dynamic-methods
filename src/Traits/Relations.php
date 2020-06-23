<?php

namespace LaravelEnso\DynamicMethods\Traits;

trait Relations
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
}
