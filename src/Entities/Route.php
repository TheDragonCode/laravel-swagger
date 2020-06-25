<?php

namespace Helldar\LaravelSwagger\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Route as RouteInstance;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Support\Facades\Route as RouteCollection;
use Illuminate\Support\Str;

final class Route implements Arrayable
{
    protected $route;

    public function __construct(RouteInstance $route = null)
    {
        $this->route = $route;
    }

    /**
     * @return \Helldar\LaravelSwagger\Entities\Route[]
     */
    public function mapped(): array
    {
        return $this->map(
            RouteCollection::getRoutes()
        );
    }

    /**
     * @param  \Illuminate\Routing\RouteCollectionInterface  $routes
     *
     * @return array
     */
    public function map(RouteCollectionInterface $routes)
    {
        return array_map(static function ($route) {
            return new static($route);
        }, $routes->getRoutes());
    }

    public function middleware(): array
    {
        return $this->route->getAction('middleware');
    }

    public function action(): string
    {
        return $this->route->getActionMethod();
    }

    public function classname(): string
    {
        return Str::before($this->route->getActionName(), '@');
    }

    public function uri(): string
    {
        return Str::start($this->route->uri(), '/');
    }

    public function methods()
    {
        return $this->route->methods();
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function toArray()
    {
        return ['foo'];
    }
}
