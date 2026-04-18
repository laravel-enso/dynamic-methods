<?php

namespace LaravelEnso\DynamicMethods\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use ReflectionProperty;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures();
    }

    protected function tearDown(): void
    {
        $this->removeRuntimeFixturePackage();

        parent::tearDown();
    }

    protected function loadFixtures(): void
    {
        foreach (File::allFiles(__DIR__.'/Fixtures') as $file) {
            if ($file->getExtension() === 'php') {
                require_once $file->getRealPath();
            }
        }
    }

    protected function installRuntimeFixturePackage(): string
    {
        $source = __DIR__.'/Fixtures/FixtureVendorPackage';
        $destination = base_path('vendor/laravel-enso-fixture/dynamic-package');

        File::deleteDirectory(dirname($destination));
        File::copyDirectory($source, $destination);

        return $destination;
    }

    protected function removeRuntimeFixturePackage(): void
    {
        File::deleteDirectory(base_path('vendor/laravel-enso-fixture'));
    }

    protected function resetMethods(string $class): void
    {
        $property = new ReflectionProperty($class, 'methodResolvers');
        $property->setValue([]);
    }

    protected function resetStaticMethods(string $class): void
    {
        $property = new ReflectionProperty($class, 'staticMethodResolvers');
        $property->setValue([]);
    }

    protected function resetRelations(string $class): void
    {
        $reflection = new ReflectionClass(Model::class);
        $property = $reflection->getProperty('relationResolvers');
        $resolvers = $property->getValue();

        unset($resolvers[$class]);

        $property->setValue($resolvers);
    }
}
