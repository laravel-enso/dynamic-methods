<?php

namespace LaravelEnso\DynamicMethods\Exceptions;

use InvalidArgumentException;

class Dyanmic extends InvalidArgumentException
{
    public static function invalid($dynamic)
    {
        $class = $dynamic::class;

        $message = "The provided dynamic '{$class}' must implement the Method or Relation contract";

        return new self($message);
    }
}
