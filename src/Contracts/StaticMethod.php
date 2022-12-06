<?php

namespace LaravelEnso\DynamicMethods\Contracts;

use Closure;

interface StaticMethod
{
    public function name(): string;

    public function closure(): Closure;

    public function bindTo(): array;
}
