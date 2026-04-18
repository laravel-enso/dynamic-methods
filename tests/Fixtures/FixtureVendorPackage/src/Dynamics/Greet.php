<?php

namespace FixtureVendor\DynamicPackage\Dynamics;

use Closure;
use LaravelEnso\DynamicMethods\Contracts\Method;
use LaravelEnso\DynamicMethods\Tests\Fixtures\TestModel;

class Greet implements Method
{
    public function bindTo(): array
    {
        return [TestModel::class];
    }

    public function name(): string
    {
        return 'greet';
    }

    public function closure(): Closure
    {
        return fn (string $name): string => "Hello {$name}";
    }
}
