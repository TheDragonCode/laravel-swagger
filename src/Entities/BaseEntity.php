<?php

namespace Helldar\LaravelSwagger\Entities;

use Helldar\LaravelSwagger\Traits\Filterable;
use Helldar\LaravelSwagger\Traits\Makeable;

abstract class BaseEntity
{
    use Makeable;
    use Filterable;
}
