<?php

namespace Helldar\LaravelSwagger\Support;

use Illuminate\Support\Facades\Config as IlluminateConfig;

final class Config
{
    public const KEY = 'laravel-swagger';

    public function get($key, $default = null)
    {
        return IlluminateConfig::get($this->compileKey($key), $default);
    }

    protected function compileKey($key)
    {
        return static::KEY . '.' . $key;
    }
}
