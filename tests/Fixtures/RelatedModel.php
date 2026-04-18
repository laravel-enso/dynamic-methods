<?php

namespace LaravelEnso\DynamicMethods\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class RelatedModel extends Model
{
    protected $table = 'users';

    protected $guarded = [];
}
