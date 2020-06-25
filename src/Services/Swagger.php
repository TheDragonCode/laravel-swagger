<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Entities\Route;
use Helldar\LaravelSwagger\Facades\Config;
use Illuminate\Contracts\Support\Arrayable;

final class Swagger implements Arrayable
{
    const OPENAPI = '3.0.0';

    protected $paths = [];

    public function appName(): string
    {
        return Config::get('title');
    }

    public function apiVersion(): string
    {
        return Config::get('version');
    }

    public function servers(): array
    {
        return Config::get('servers', []);
    }

    public function addRoute(Route $route)
    {
        foreach ($route->methods() as $method) {
            $this->paths[$route->uri()][$method] = $route->toArray();
        }
    }

    public function toArray()
    {
        return [
            'openapi' => static::OPENAPI,
            'info'    => [
                'title'   => $this->appName(),
                'version' => $this->apiVersion(),
            ],
            'servers' => $this->servers(),
            'paths'   => $this->paths,
        ];
    }
}
