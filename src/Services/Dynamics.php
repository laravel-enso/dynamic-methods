<?php

namespace LaravelEnso\DynamicMethods\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use LaravelEnso\DynamicMethods\Contracts\Method;
use LaravelEnso\DynamicMethods\Contracts\Relation;
use LaravelEnso\DynamicMethods\Contracts\StaticMethod;
use LaravelEnso\Helpers\Services\JsonReader;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class Dynamics
{
    private const Folder = 'Dynamics';

    private array $composer;

    public function __construct(private string $sourceFolder)
    {
    }

    public function get(): Collection
    {
        return File::isDirectory($this->folder())
            ? Collection::wrap(File::allFiles($this->folder()))
            ->map(fn (SplFileInfo $file) => $this->class($file))
            ->filter(fn ($class) => $this->qualifies($class))
            ->map(fn ($class) => new $class())
            : new Collection();
    }

    private function qualifies(string $class): bool
    {
        $instance = new ReflectionClass($class);

        return $instance->implementsInterface(Relation::class)
            || $instance->implementsInterface(Method::class)
            || $instance->implementsInterface(StaticMethod::class);
    }

    private function class(SplFileInfo $file): string
    {
        return Collection::wrap([
            rtrim($this->psr4Namespace(), '\\'),
            self::Folder,
            $file->getRelativePath(self::Folder),
            $file->getFilenameWithoutExtension(),
        ])->filter()->implode('\\');
    }

    private function folder(): string
    {
        return Collection::wrap([
            $this->sourceFolder,
            rtrim($this->psr4Folder(), DIRECTORY_SEPARATOR),
            self::Folder,
        ])->implode(DIRECTORY_SEPARATOR);
    }

    private function psr4Folder(): string
    {
        return $this->composer()['autoload']['psr-4'][$this->psr4Namespace()];
    }

    private function psr4Namespace(): string
    {
        return key($this->composer()['autoload']['psr-4']);
    }

    private function composer(): array
    {
        return $this->composer
            ??= (new JsonReader($this->composerPath()))->array();
    }

    private function composerPath(): string
    {
        return $this->sourceFolder.DIRECTORY_SEPARATOR.'composer.json';
    }
}
