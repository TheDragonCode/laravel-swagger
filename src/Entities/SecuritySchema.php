<?php

namespace Helldar\LaravelSwagger\Entities;

use Helldar\LaravelSwagger\Contracts\Schema as SchemaContract;
use Helldar\LaravelSwagger\Traits\Makeable;

final class SecuritySchema extends BaseEntity implements SchemaContract
{
    use Makeable;

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
