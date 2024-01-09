<?php

namespace LaravelEnso\DynamicMethods\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use LaravelEnso\DynamicMethods\Contracts\Relation as Contract;

class Relation
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

    protected function handle(Model $object): void
    {
        $args = [$this->dynamic->name(), $this->dynamic->closure()];

        $object::resolveRelationUsing(...$args);
    }
}
