<?php

namespace LaravelEnso\DynamicMethods\Tests\Unit;

require_once __DIR__.'/../TestCase.php';

use LaravelEnso\DynamicMethods\Tests\Fixtures\TestModel;
use LaravelEnso\DynamicMethods\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AbilitiesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resetMethods(TestModel::class);
    }

    #[Test]
    public function detects_dynamic_scope_via_has_named_scope(): void
    {
        TestModel::resolveMethodUsing('scopePopular', fn ($query) => $query->where('id', '>', 0));

        $model = new TestModel();

        $this->assertTrue($model->hasNamedScope('popular'));
        $this->assertStringContainsString('"id" > ?', TestModel::query()->popular()->toSql());
    }

    #[Test]
    public function detects_dynamic_get_mutator_via_has_get_mutator(): void
    {
        TestModel::resolveMethodUsing('getDisplayNameAttribute', fn ($value): string => strtoupper($value));

        $model = new TestModel();
        $model->setRawAttributes(['display_name' => 'adi']);

        $this->assertTrue($model->hasGetMutator('display_name'));
        $this->assertSame('ADI', $model->display_name);
    }

    #[Test]
    public function detects_dynamic_set_mutator_via_has_set_mutator(): void
    {
        TestModel::resolveMethodUsing('setDisplayNameAttribute', function ($value): void {
            $this->attributes['display_name'] = strtoupper($value);
        });

        $model = new TestModel();
        $model->display_name = 'adi';

        $this->assertTrue($model->hasSetMutator('display_name'));
        $this->assertSame('ADI', $model->getAttributes()['display_name']);
    }
}
