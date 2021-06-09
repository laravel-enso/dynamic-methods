<?php

namespace LaravelEnso\DynamicMethods\Services;

use LaravelEnso\DynamicMethods\Contracts\Method as Contract;
use LaravelEnso\DynamicMethods\Exceptions\Model;
use ReflectionClass;

class Method
{
    public function __construct(
        private string $model,
        private Contract $method
    ) {
    }

    public function bind()
    {
        $this->validate();

        $this->model::addDynamicMethod(
            $this->method->name(),
            $this->method->closure()
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
