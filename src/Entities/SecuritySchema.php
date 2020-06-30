<?php

namespace Helldar\LaravelSwagger\Entities;

use Helldar\LaravelSwagger\Contracts\Schema as SchemaContract;

final class SecuritySchema extends BaseEntity implements SchemaContract
{
    protected $name;

    protected $data;

    public function __construct(string $name, array $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function type(): string
    {
        return 'securitySchemes';
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
