<?php

namespace Helldar\LaravelSwagger\Traits;

trait Makeable
{
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }
}
