<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelSwagger\Traits\Makeable;
use Illuminate\Contracts\Support\Arrayable;

abstract class BaseModel implements Arrayable
{
    use Makeable;
}
