<?php

namespace Helldar\LaravelSwagger\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface Swagger extends Arrayable, Jsonable
{
    public function getVersion(): string;

    public function setVersion(string $version): self;

    public function addPath(Pathable $path): self;
}
