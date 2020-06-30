<?php

namespace Helldar\LaravelSwagger\Facades;

use Helldar\LaravelSwagger\Support\Config as ConfigSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get($key, $default = null)
 *
 * @method static string title()
 * @method static string version()
 * @method static string routesUri()
 * @method static array routesHideMethods()
 * @method static array routesHideMatching()
 * @method static array servers()
 * @method static array securitySchemes()
 * @method static array exceptions()
 * @method static string path()
 * @method static string filename()
 *
 * @method static string key()
 * @method static string file()
 */
final class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ConfigSupport::class;
    }
}
