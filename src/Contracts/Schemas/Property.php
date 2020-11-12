<?php

namespace Helldar\LaravelSwagger\Contracts\Schemas;

use Helldar\LaravelSwagger\Contracts\Keyable;
use Illuminate\Contracts\Support\Arrayable;

interface Property extends Arrayable, Keyable
{
    public function setKey(string $key): self;

    public function getType(): string;

    public function setType(string $type): self;

    public function getExample();

    public function setExample($value): self;
}
