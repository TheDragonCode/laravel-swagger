<?php

namespace Helldar\LaravelSwagger\Entities;

use Illuminate\Contracts\Support\Arrayable;
use phpDocumentor\Reflection\DocBlock;
use ReflectionParameter;

final class Parameter extends BaseEntity implements Arrayable
{
    protected $doc_block;

    protected $parameter;

    public function __construct(ReflectionParameter $parameter, DocBlock $doc_block = null)
    {
        $this->parameter = $parameter;
        $this->doc_block = $doc_block;
    }

    public function toArray()
    {
        return $this->filter([
            'name'        => $this->name(),
            'in'          => $this->in(),
            'description' => $this->description(),
            'required'    => $this->isRequired(),
        ]);
    }

    protected function name(): string
    {
        return $this->parameter->getName();
    }

    protected function in(): string
    {
        return 'path';
    }

    protected function description(): ?string
    {
        foreach ($this->doc_block->getTagsByName('param') as $param) {
            if ($param->getVariableName() === $this->name()) {
                return optional($param->getDescription())->getBodyTemplate();
            }
        }

        return null;
    }

    protected function isRequired(): bool
    {
        return ! $this->parameter->isOptional();
    }
}
