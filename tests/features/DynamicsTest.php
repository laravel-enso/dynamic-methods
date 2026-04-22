<?php

namespace LaravelEnso\DynamicMethods\Tests\Features;

require_once __DIR__.'/../TestCase.php';

use FixtureVendor\DynamicPackage\Dynamics\Greet;
use FixtureVendor\DynamicPackage\Dynamics\Related;
use FixtureVendor\DynamicPackage\Dynamics\StaticGreeting;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelEnso\DynamicMethods\Services\Binder;
use LaravelEnso\DynamicMethods\Services\Dynamics;
use LaravelEnso\DynamicMethods\Tests\Fixtures\TestModel;
use LaravelEnso\DynamicMethods\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DynamicsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resetMethods(TestModel::class);
        $this->resetStaticMethods(TestModel::class);
        $this->resetRelations(TestModel::class);
    }

    #[Test]
    public function discovers_dynamic_classes_from_source_folder(): void
    {
        $dynamics = (new Dynamics(__DIR__.'/../Fixtures/FixtureVendorPackage'))->get();

        $this->assertCount(3, $dynamics);
        $this->assertTrue($dynamics->contains(fn ($dynamic) => $dynamic instanceof Greet));
        $this->assertTrue($dynamics->contains(fn ($dynamic) => $dynamic instanceof Related));
        $this->assertTrue($dynamics->contains(fn ($dynamic) => $dynamic instanceof StaticGreeting));
    }

    #[Test]
    public function ignores_classes_that_do_not_implement_dynamic_contracts(): void
    {
        $classes = (new Dynamics(__DIR__.'/../Fixtures/FixtureVendorPackage'))->get()
            ->map(fn ($dynamic) => $dynamic::class);

        $this->assertCount(3, $classes);
        $this->assertNotContains('FixtureVendor\\DynamicPackage\\Dynamics\\Noise', $classes);
    }

    #[Test]
    public function binds_dynamic_methods_relations_and_static_methods_for_target_classes(): void
    {
        $this->installRuntimeFixturePackage();
        config()->set('enso.dynamics.vendors', [$this->runtimeFixtureVendor()]);

        (new Binder())->handle();

        $model = new TestModel();

        $this->assertSame('Hello Adi', $model->greet('Adi'));
        $this->assertInstanceOf(BelongsTo::class, $model->related());
        $this->assertSame('Static Adi', TestModel::staticGreeting('Adi'));
    }
}
