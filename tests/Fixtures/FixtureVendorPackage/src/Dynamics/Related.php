<?php

namespace FixtureVendor\DynamicPackage\Dynamics;

use Closure;
use LaravelEnso\DynamicMethods\Contracts\Relation;
use LaravelEnso\DynamicMethods\Tests\Fixtures\RelatedModel;
use LaravelEnso\DynamicMethods\Tests\Fixtures\TestModel;

class Related implements Relation
{
    public function bindTo(): array
    {
        return [TestModel::class];
    }

    public function name(): string
    {
        return 'related';
    }

    public function closure(): Closure
    {
        return fn (TestModel $model) => $model->belongsTo(RelatedModel::class, 'id');
    }
}
