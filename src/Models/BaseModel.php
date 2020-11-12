<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelRoutesCore\Traits\Makeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

abstract class BaseModel implements Arrayable
{
    use Makeable;

    protected $attributes = [];

    public function toArray()
    {
        return $this->getAttributes();
    }

    protected function pushAttribute($value): void
    {
        $this->attributes[] = $value;
    }

    protected function setAttribute(string $key, $value): void
    {
        Arr::set($this->attributes, $key, $value);
    }

    protected function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    protected function getAttributes(): array
    {
        return $this->attributes;
    }
}
