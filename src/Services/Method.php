<?php

namespace LaravelEnso\DynamicMethods\Services;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\App;
use LaravelEnso\DynamicMethods\Contracts\Method as MethodContract;
use LaravelEnso\DynamicMethods\Contracts\Relation;
use LaravelEnso\DynamicMethods\Contracts\Relation as RelationContract;
use LaravelEnso\DynamicMethods\Exceptions\Model;
use ReflectionClass;

class Method
{
    public function __construct(
        private string $model,
        private MethodContract|RelationContract $method
    ) {
    }

    public function bind(): void
    {
        $this->validate();

        if ($this->method instanceof Relation) {
            $this->addRelations();
        } else {
            $this->addMethod();
        }
    }

    private function addMethod(): void
    {
        $this->model::addDynamicMethod(
            $this->method->name(),
            $this->method->closure()
        );
    }

    private function addRelations(): void
    {
        $this->addRelation()
            ->addBindingRelation();
    }

    private function addRelation(): self
    {
        $this->model::resolveRelationUsing(
            $this->method->name(),
            $this->method->closure(),
        );

        return $this;
    }

    private function addBindingRelation(): void
    {
        $instance = App::make($this->model);

        get_class($instance)::resolveRelationUsing(
            $this->method->name(),
            $this->method->closure(),
        );
    }

    private function validate(): void
    {
        if (! class_exists($this->model)) {
            throw Model::doesntExist($this->model);
        }

        $reflection = (new ReflectionClass($this->model));

        if (! $reflection->isSubclassOf(EloquentModel::class)) {
            throw Model::isNotModel($this->model);
        }

        $missingContract = $reflection instanceof MethodContract
            && ! $reflection->implementsInterface(MethodContract::class);

        if ($missingContract) {
            throw Model::missingMethod($this->model);
        }
    }
}
