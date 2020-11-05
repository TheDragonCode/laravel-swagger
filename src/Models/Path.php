<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelRoutesCore\Models\Route;
use Helldar\LaravelSwagger\Contracts\Pathable;

final class Path extends BaseModel implements Pathable
{
    /** @var \Helldar\LaravelRoutesCore\Models\Route */
    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function toArray()
    {
        $path = $this->route->getPath();

        $result = [];

        foreach ($this->route->getMethods() as $method) {
            $result[$path][$method] = $this->route;
        }

        return $result;
    }
}
