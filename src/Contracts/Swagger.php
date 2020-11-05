<?php

namespace Helldar\LaravelSwagger\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface Swagger extends Arrayable, Jsonable
{
    public function addPath(Pathable $path): self;
}
