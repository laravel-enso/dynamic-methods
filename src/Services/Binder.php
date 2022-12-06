<?php

namespace LaravelEnso\DynamicMethods\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use LaravelEnso\DynamicMethods\Contracts\Method as DynamicMethod;
use LaravelEnso\DynamicMethods\Contracts\Relation as DynamicRelation;

class Binder
{
    public function handle(): void
    {
        $this->dynamics()
            ->each(fn ($dynamic) => $this->bind($dynamic));
    }

    private function bind(DynamicMethod | DynamicRelation $dynamic)
    {
        if ($dynamic instanceof DynamicRelation) {
            (new Relation($dynamic))->bind();
        } elseif ($dynamic instanceof DynamicMethod) {
            (new Method($dynamic))->bind();
        } else {
            (new StaticMethod($dynamic))->bind();
        }
    }

    private function dynamics(): Collection
    {
        return Collection::wrap(Config::get('enso.dymamics.vendors'))
            ->map(fn ($vendor) => base_path("vendor/{$vendor}"))
            ->map(fn ($vendor) => File::directories($vendor))
            ->flatten()
            ->push(base_path())
            ->mapInto(Dynamics::class)
            ->map->get()
            ->filter->isNotEmpty()
            ->collapse();
    }
}
