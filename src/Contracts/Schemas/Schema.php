<?php

namespace Helldar\LaravelSwagger\Contracts\Schemas;

use Helldar\LaravelSwagger\Contracts\Keyable;
use Illuminate\Contracts\Support\Arrayable;

interface Schema extends Arrayable, Keyable
{
    public function addProperty(Property $property): self;

    public function getProperty(string $key): Property;
}
