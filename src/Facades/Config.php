<?php

namespace Helldar\LaravelSwagger\Facades;

use Helldar\LaravelSwagger\Support\Config as ConfigSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get($key, $default = null)
 */
final class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ConfigSupport::class;
    }
}
