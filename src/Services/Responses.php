<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Entities\Response;
use Helldar\LaravelSwagger\Facades\Config;
use Illuminate\Support\Arr;

final class Responses
{
    protected static $items = [];

    public function get(): array
    {
        if (! static::$items) {
            foreach ($this->getExceptionClasses() as $code => $item) {
                static::$items[$code] = Response::make(
                    $code,
                    Arr::get($item, 'name'),
                    Arr::get($item, 'description')
                );
            }
        }

        return static::$items;
    }

    protected function getExceptionClasses(): array
    {
        return Config::exceptions();
    }
}
