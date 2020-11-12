<?php

namespace Helldar\LaravelSwagger\Contracts\Schemas;

use Illuminate\Contracts\Support\Arrayable;

interface Responsible extends Arrayable
{
    public function getCode(): int;

    public function setCode(int $code): self;
}
