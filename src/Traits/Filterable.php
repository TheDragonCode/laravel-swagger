<?php

namespace Helldar\LaravelSwagger\Traits;

trait Filterable
{
    protected function filter(array $array)
    {
        return array_filter($array, static function ($item) {
            return ! empty($item);
        });
    }
}
