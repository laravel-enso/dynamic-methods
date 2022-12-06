<?php

namespace LaravelEnso\DynamicMethods\Services;

use Illuminate\Support\Collection;
use LaravelEnso\DynamicMethods\Contracts\DynamicStaticMethods;
use LaravelEnso\DynamicMethods\Contracts\StaticMethod as Contract;

class StaticMethod
{
    public function __construct(private Contract $dynamic)
    {
    }

    public function bind(): void
    {
        Collection::wrap($this->dynamic->bindTo())
            ->map(fn ($class) => new $class())
            ->each(fn ($object) => $this->handle($object));
    }

    protected function handle(DynamicStaticMethods $object)
    {
        $args = [$this->dynamic->name(), $this->dynamic->closure()];

        $object::resolveStaticMethodUsing(...$args);
    }
}
