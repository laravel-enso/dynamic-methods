<?php

namespace LaravelEnso\DynamicMethods\Tests\Fixtures;

require_once __DIR__.'/ParentStaticCallable.php';

use LaravelEnso\DynamicMethods\Traits\StaticMethods;

class ChildStaticMethodsTarget extends ParentStaticCallable
{
    use StaticMethods;
}
