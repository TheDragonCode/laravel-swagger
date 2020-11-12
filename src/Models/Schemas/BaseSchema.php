<?php

namespace Helldar\LaravelSwagger\Models\Schemas;

use Helldar\LaravelSwagger\Contracts\Schemas\Property;
use Helldar\LaravelSwagger\Contracts\Schemas\Schema;
use Helldar\LaravelSwagger\Exceptions\UnknownPropertyNameException;
use Helldar\LaravelSwagger\Facades\Hash;
use Helldar\LaravelSwagger\Models\BaseModel;
use Helldar\LaravelSwagger\Models\Properties\Concerns\Castable;
use Illuminate\Support\Arr;

abstract class BaseSchema extends BaseModel implements Schema
{
    use Castable;

    protected $attributes = [
        'type' => 'object',
    ];

    public function getKey(): string
    {
        return Hash::make($this);
    }

    public function addProperty(Property $property): Schema
    {
        $properties = $this->properties();

        Arr::set($properties, $property->getKey(), $property);

        $this->setAttribute('properties', $properties);

        return $this;
    }

    public function getProperty(string $key): Property
    {
        if (! Arr::exists($this->properties(), $key)) {
            throw new UnknownPropertyNameException($key);
        }

        return Arr::get($this->properties(), $key);
    }

    public function hasProperty(string $key): bool
    {
        return Arr::exists($this->properties(), $key);
    }

    public function setDescription($description): Schema
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    public function setType(string $type): Schema
    {
        $this->setAttribute('type', $type);

        return $this;
    }

    protected function properties(): array
    {
        return $this->getAttribute('properties', []);
    }

    protected function resolve($class)
    {
        return is_string($class) ? new $class : $class;
    }
}
