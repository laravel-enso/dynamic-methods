<?php

namespace LaravelEnso\DynamicMethods\Exceptions;

use InvalidArgumentException;

class Model extends InvalidArgumentException
{
    public static function doesntExist(string $model)
    {
        return new self("The provided model '{$model}' does not exist");
    }

    public static function missingMethod(string $model)
    {
        return new self("The provided model '{$model}' is not using DynamicMethods");
    }

    public static function isNotModel(string $model)
    {
        return new self("The provided class '{$model}' is not an Eloqunet Model");
    }
}
