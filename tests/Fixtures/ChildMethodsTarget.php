<?php

namespace LaravelEnso\DynamicMethods\Tests\Fixtures;

require_once __DIR__.'/ParentCallable.php';

use LaravelEnso\DynamicMethods\Traits\Methods;

class ChildMethodsTarget extends ParentCallable
{
    use Methods;
}
