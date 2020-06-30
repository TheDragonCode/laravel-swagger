<?php

namespace Helldar\LaravelSwagger\Entities;

use Helldar\LaravelSwagger\Contracts\Responsible;
use Illuminate\Contracts\Support\Arrayable;

final class Response extends BaseEntity implements Responsible, Arrayable
{
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
            'content'     => $this->content(),
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

    public function content(): array
    {
        return [
            'application/json' => [
                'schema' => 'aaa',
            ],
        ];
    }
}
