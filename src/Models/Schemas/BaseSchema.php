<?php

namespace Helldar\LaravelSwagger\Models\Schemas;

use Helldar\LaravelSwagger\Contracts\Schemas\Property;
use Helldar\LaravelSwagger\Contracts\Schemas\Schema;
use Helldar\LaravelSwagger\Exceptions\UnknownPropertyNameException;
use Illuminate\Support\Arr;

abstract class BaseSchema implements Schema
{
    public $description;

    public $properties = [];

    public $type = 'object';

    public function getKey(): string
    {
        return md5(get_class($this));
    }

    public function addProperty(Property $property): Schema
    {
        Arr::set($this->properties, $property->getKey(), $property);

        return $this;
    }

    public function getProperty(string $key): Property
    {
        if (! Arr::exists($this->properties, $key)) {
            throw new UnknownPropertyNameException($key);
        }

        return Arr::get($this->properties, $key);
    }

    public function toArray()
    {
        return [
            'description' => $this->description,
            'properties'  => $this->properties,
            'type'        => $this->type,
        ];
    }

    public function setDescription($description): Schema
    {
        $this->description = $description;

        return $this;
    }

    public function setType(string $type): Schema
    {
        $this->type = $type;

        return $this;
    }
}
