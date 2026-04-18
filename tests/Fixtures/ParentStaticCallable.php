<?php

namespace LaravelEnso\DynamicMethods\Tests\Fixtures;

class ParentStaticCallable
{
    public static function __callStatic($method, $arguments)
    {
        return $method.':'.implode(',', $arguments);
    }
}
