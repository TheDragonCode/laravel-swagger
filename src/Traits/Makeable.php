<?php

namespace Helldar\LaravelSwagger\Traits;

trait Makeable
{
    public static function make(...$args)
    {
        return new static(...$args);
    }
}
