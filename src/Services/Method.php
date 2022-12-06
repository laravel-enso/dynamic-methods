<?php

namespace LaravelEnso\DynamicMethods\Services;

use Illuminate\Support\Collection;
use LaravelEnso\DynamicMethods\Contracts\DynamicMethods;
use LaravelEnso\DynamicMethods\Contracts\Method as Contract;

class Method
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

    protected function handle(DynamicMethods $object)
    {
        $args = [$this->dynamic->name(), $this->dynamic->closure()];

        $object::resolveMethodUsing(...$args);
    }
}
