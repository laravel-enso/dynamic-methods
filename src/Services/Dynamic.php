<?php

namespace LaravelEnso\DynamicMethods\Services;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\DynamicMethods\Contracts\Method;
use LaravelEnso\DynamicMethods\Contracts\Relation;
use LaravelEnso\DynamicMethods\Exceptions\Dyanmic as Exception;

class Dynamic
{
    public function __construct(
        private Model $model,
        private Method|Relation $dynamic,
    ) {
    }

    public function bind(): void
    {
        if ($this->dynamic instanceof Relation) {
            $this->addRelation();
        } elseif ($this->dynamic instanceof Method) {
            $this->addMethod();
        } else {
            throw Exception::invalid($this->dynamic);
        }
    }

    private function addMethod(): void
    {
        $this->model::addDynamicMethod(
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
