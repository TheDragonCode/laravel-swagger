<?php

namespace Helldar\LaravelSwagger\Entities\Schemas;

use Helldar\LaravelSwagger\Contracts\Schema as SchemaContract;
use Helldar\LaravelSwagger\Entities\BaseEntity;

abstract class BaseSchema extends BaseEntity implements SchemaContract
{
    protected $name;

    protected $data;

    public function __construct(string $name, array $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function toArray()
    {
        return $this->data;
    }
}
