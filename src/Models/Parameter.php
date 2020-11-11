<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelSwagger\Models\Schemas\Reference;
use Illuminate\Support\Str;

final class Parameter extends BaseModel
{
    protected $parameter;

    public function __construct(string $parameter)
    {
        $this->parameter = $parameter;
    }

    public function toArray()
    {
        return [
            'name'     => $this->name(),
            'in'       => $this->in(),
            'required' => $this->required(),
            'schema'   => [
                '$ref' => $this->schemaReference(),
            ],
        ];
    }

    protected function name(): string
    {
        return trim($this->parameter, '{}?');
    }

    protected function in(): string
    {
        return 'path';
    }

    protected function required(): bool
    {
        return ! Str::contains($this->parameter, '?');
    }

    protected function schemaReference(): string
    {
        return Reference::make()->basic($this->name());
    }
}
