<?php

namespace Helldar\LaravelSwagger\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Schema extends Arrayable
{
    public function type(): string;

    public function name(): string;
}
