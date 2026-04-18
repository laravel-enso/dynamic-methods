<?php

namespace LaravelEnso\DynamicMethods\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\DynamicMethods\Contracts\DynamicMethods;
use LaravelEnso\DynamicMethods\Contracts\DynamicStaticMethods;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\DynamicMethods\Traits\StaticMethods;

class TestModel extends Model implements DynamicMethods, DynamicStaticMethods
{
    use Abilities;
    use StaticMethods;

    protected $table = 'users';

    protected $guarded = [];
}
