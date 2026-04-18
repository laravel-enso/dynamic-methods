<?php

namespace LaravelEnso\DynamicMethods\Tests\Unit;

require_once __DIR__.'/../TestCase.php';

use BadMethodCallException;
use LaravelEnso\DynamicMethods\Tests\Fixtures\ChildMethodsTarget;
use LaravelEnso\DynamicMethods\Tests\Fixtures\ChildStaticMethodsTarget;
use LaravelEnso\DynamicMethods\Tests\Fixtures\NakedMethodsTarget;
use LaravelEnso\DynamicMethods\Tests\Fixtures\NakedStaticMethodsTarget;
use LaravelEnso\DynamicMethods\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MethodsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resetMethods(NakedMethodsTarget::class);
        $this->resetMethods(ChildMethodsTarget::class);
        $this->resetStaticMethods(NakedStaticMethodsTarget::class);
        $this->resetStaticMethods(ChildStaticMethodsTarget::class);
    }

    #[Test]
    public function calls_bound_dynamic_instance_method(): void
    {
        NakedMethodsTarget::resolveMethodUsing('hello', fn (string $name): string => "Hello {$name}");

        $this->assertSame('Hello Adi', (new NakedMethodsTarget())->hello('Adi'));
    }

    #[Test]
    public function falls_back_to_parent_call_when_instance_method_is_missing(): void
    {
        $this->assertSame('missing:one,two', (new ChildMethodsTarget())->missing('one', 'two'));
    }

    #[Test]
    public function throws_when_instance_method_is_missing_and_parent_cannot_handle_it(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Method '.NakedMethodsTarget::class.'::missing() not found');

        (new NakedMethodsTarget())->missing();
    }

    #[Test]
    public function calls_bound_dynamic_static_method(): void
    {
        NakedStaticMethodsTarget::resolveStaticMethodUsing('hello', fn (string $name): string => "Hello {$name}");

        $this->assertSame('Hello Adi', NakedStaticMethodsTarget::hello('Adi'));
    }

    #[Test]
    public function falls_back_to_parent_call_static_when_method_is_missing(): void
    {
        $this->assertSame('missing:one,two', ChildStaticMethodsTarget::missing('one', 'two'));
    }

    #[Test]
    public function throws_when_static_method_is_missing_and_parent_cannot_handle_it(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Static method '.NakedStaticMethodsTarget::class.'::missing() not found');

        NakedStaticMethodsTarget::missing();
    }
}
