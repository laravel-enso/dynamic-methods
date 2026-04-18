<?php

namespace FixtureVendor\DynamicPackage\Dynamics;

use Closure;
use LaravelEnso\DynamicMethods\Contracts\StaticMethod;
use LaravelEnso\DynamicMethods\Tests\Fixtures\TestModel;

class StaticGreeting implements StaticMethod
{
    public function bindTo(): array
    {
        return [TestModel::class];
    }

    public function name(): string
    {
        return 'staticGreeting';
    }

    public function closure(): Closure
    {
        return fn (string $name): string => "Static {$name}";
    }
}
