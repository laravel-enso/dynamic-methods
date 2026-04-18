<?php

namespace LaravelEnso\DynamicMethods\Tests\Fixtures;

class ParentCallable
{
    public function __call($method, $arguments)
    {
        return $method.':'.implode(',', $arguments);
    }
}
