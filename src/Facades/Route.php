<?php

namespace Helldar\LaravelSwagger\Facades;

use Helldar\LaravelSwagger\Entities\Route as RouteEntity;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection|\Helldar\LaravelSwagger\Entities\Route[] map(RouteCollectionInterface $collection)
 * @method static \Illuminate\Support\Collection|\Helldar\LaravelSwagger\Entities\Route[] mapped()
 */
final class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RouteEntity::class;
    }
}
