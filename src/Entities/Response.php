<?php

namespace Helldar\LaravelSwagger\Entities;

use Helldar\LaravelSwagger\Contracts\Responsible;
use Helldar\LaravelSwagger\Traits\Makeable;
use Illuminate\Contracts\Support\Arrayable;

final class Response extends BaseEntity implements Responsible, Arrayable
{
    use Makeable;

    protected $code;

    protected $class;

    protected $description;

    public function __construct(int $code, string $class, string $description)
    {
        $this->code        = $code;
        $this->class       = $class;
        $this->description = $description;
    }

    public function toArray()
    {
        return [
            'description' => $this->description(),
        ];
    }

    public function code(): int
    {
        return $this->code;
    }

    public function description(): string
    {
        return $this->description;
    }
}
