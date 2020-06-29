<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Contracts\Route;
use Helldar\LaravelSwagger\Contracts\Schema;
use Helldar\LaravelSwagger\Facades\Config;
use Helldar\LaravelSwagger\Facades\Responses as ResponseHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

final class Swagger implements Arrayable, Jsonable
{
    const OPENAPI = '3.0.0';

    protected $paths = [];

    protected $components = [];

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
        $servers = Config::get('servers', []);

        if ($routes = trim($this->routes(), '/*')) {
            foreach ($servers as &$server) {
                $url = Arr::get($server, 'url');
                $url = Str::finish($url, '/');

                Arr::set($server, 'url', $url . '/' . $routes);
            }
        }

        return $servers;
    }

    public function tags(): array
    {
        return Config::get('tags', []);
    }

    public function addRoute(Route $route)
    {
        foreach ($route->methods() as $method) {
            $method = Str::lower($method);

            if ($method === 'head') {
                continue;
            }

            $this->paths[$route->uri()][$method] = $route->addResponses(ResponseHelper::get());
        }
    }

    public function addComponent(Schema $schema): self
    {
        $this->components[$schema->type()][$schema->name()] = $schema;

        return $this;
    }

    public function toArray()
    {
        return $this->process([
            'openapi' => static::OPENAPI,

            'info' => [
                'title'   => $this->appName(),
                'version' => $this->apiVersion(),
            ],

            'servers'    => $this->servers(),
            'paths'      => $this->paths,
            'components' => $this->components,
            'tags'       => $this->tags(),
        ]);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    protected function routes(): string
    {
        return Config::get('routes');
    }

    protected function process(array $array)
    {
        return array_map(function ($item) {
            if ($item instanceof Arrayable) {
                return $this->process($item->toArray());
            }

            if (is_array($item)) {
                return $this->process($item);
            }

            if ($item instanceof Stringable) {
                return (string) $item;
            }

            return $item;
        }, $array);
    }
}
