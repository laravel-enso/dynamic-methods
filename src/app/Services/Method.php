<?php

namespace LaravelEnso\DynamicMethods\App\Services;

use LaravelEnso\DynamicMethods\App\Contracts\Method as Contract;
use LaravelEnso\DynamicMethods\App\Exceptions\Model;
use ReflectionClass;

class Method
{
    private string $model;
    private Contract $method;

    public function __construct(string $model, Contract $method)
    {
        $this->model = $model;
        $this->method = $method;
    }

    public function bind()
    {
        $this->validate();

        $this->model::addDynamicMethod(
            $this->method->name(), $this->method->closure()
        );
    }

    private function validate()
    {
        if (! class_exists($this->model)) {
            throw Model::doesntExist($this->model);
        }

        if (! (new ReflectionClass($this->model))->hasMethod('addDynamicMethod')) {
            throw Model::missingMethod($this->model);
        }
    }
}
