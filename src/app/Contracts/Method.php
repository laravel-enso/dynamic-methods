<?php
namespace LaravelEnso\DynamicMethods\App\Contracts;

use Closure;

interface Method
{
    public function name(): string;

    public function closure(): Closure;
}