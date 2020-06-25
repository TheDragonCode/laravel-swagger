<?php

namespace Helldar\LaravelSwagger\Facades;

use Helldar\LaravelSwagger\Entities\Route as RouteEntity;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Routing\Route[] map(RouteCollectionInterface $collection)
 * @method static \Helldar\LaravelSwagger\Entities\Route[] mapped()
 */
final class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RouteEntity::class;
    }
}
