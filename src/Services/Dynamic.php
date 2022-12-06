<?php

namespace LaravelEnso\DynamicMethods\Services;

use LaravelEnso\DynamicMethods\Contracts\Method;
use LaravelEnso\DynamicMethods\Contracts\Relation;

class Dynamic
{
    public function __construct(
        private object $model,
        private Method|Relation $dynamic,
    ) {
    }

    public function bind(): void
    {
        if ($this->dynamic instanceof Relation) {
            $this->addRelation();
        } elseif ($this->dynamic instanceof Method) {
            $this->addMethod();
        }
    }

    private function addMethod(): void
    {
        $this->model::resolveMethodUsing(
            $this->dynamic->name(),
            $this->dynamic->closure()
        );
    }

    private function addRelation(): void
    {
        $this->model::resolveRelationUsing(
            $this->dynamic->name(),
            $this->dynamic->closure(),
        );
    }
}
