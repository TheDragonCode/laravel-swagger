<?php

namespace Helldar\LaravelSwagger\Facades;

use Helldar\LaravelSwagger\Contracts\Swagger;
use Helldar\LaravelSwagger\Services\Files as Service;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Service swagger(Swagger $swagger)
 */
final class Files extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Service::class;
    }
}
