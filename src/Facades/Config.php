<?php

namespace Helldar\LaravelSwagger\Facades;

use Helldar\LaravelSwagger\Services\Config as Service;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string title()
 * @method static string version()
 * @method static string path(string $path = null)
 * @method static string filename(string $extension = null)
 * @method static string fullPath(string $extension = null)
 * @method static array exceptions()
 * @method static array servers()
 *
 * @method static string routesUri()
 * @method static array routesHideMethods()
 * @method static array routesHideMatching()
 *
 * @method static array securitySchemes()
 *
 * @method static array schemaProperties()
 */
final class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Service::class;
    }
}
