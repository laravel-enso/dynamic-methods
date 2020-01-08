<?php

namespace LaravelEnso\DynamicMethods\App\Exceptions;

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
}
