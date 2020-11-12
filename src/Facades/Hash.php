<?php

namespace Helldar\LaravelSwagger\Facades;

use Helldar\LaravelSwagger\Support\Hash as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string make($object)
 */
final class Hash extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
