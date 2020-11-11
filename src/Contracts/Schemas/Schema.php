<?php

namespace Helldar\LaravelSwagger\Contracts\Schemas;

use Illuminate\Contracts\Support\Arrayable;

interface Schema extends Arrayable
{
    public function getKey(): string;

    public function addProperty(Property $property): self;

    public function getProperty(string $key): Property;
}
