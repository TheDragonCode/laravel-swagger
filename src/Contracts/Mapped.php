<?php

namespace Helldar\LaravelSwagger\Contracts;

use Illuminate\Support\Collection;

interface Mapped
{
    public function mapped(): Collection;
}
