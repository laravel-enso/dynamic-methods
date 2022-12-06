<?php

namespace LaravelEnso\DynamicMethods\Contracts;

use Closure;

interface Relation
{
    public function name(): string;

    public function closure(): Closure;

    public function bindTo(): array;
}
