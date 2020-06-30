<?php

namespace Helldar\LaravelSwagger\Contracts;

use Illuminate\Support\Collection;

interface Mappable
{
    public function mapped(): Collection;
}
