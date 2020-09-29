<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Contracts\Route;
use Helldar\LaravelSwagger\Contracts\Schema;
use Helldar\LaravelSwagger\Entities\BaseEntity;
use Helldar\LaravelSwagger\Entities\Schemas\Schema as SchemaEntity;
use Helldar\LaravelSwagger\Entities\Tag;
use Helldar\LaravelSwagger\Facades\Config;
use Helldar\LaravelSwagger\Facades\Responses as ResponseHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

final class Swagger implements Arrayable, Jsonable
{
    const OPENAPI = '3.0.0';

    /** @var \Helldar\LaravelSwagger\Entities\Route[][] */
    protected $paths = [];

    protected $components = [];

    public function name(): string
    {
        return Config::title();
    }

    public function version(): string
    {
        return Config::version();
    }

    public function servers(): array
    {
        $servers = Config::servers();

        if ($routes = trim($this->routes(), '/*')) {
            foreach ($servers as &$server) {
                $url = Arr::get($server, 'url');

                Arr::set($server, 'url', $url . '/' . $routes);
            }
        }

        return $servers;
    }

    public function tags(array $tags = []): Collection
    {
        foreach ($this->paths as $path) {
            foreach ($path as $route) {
                $tags = array_merge($tags, $route->tags());
            }
        }

        return collect($tags)
            ->unique()
            ->filter()
            ->values()
            ->mapInto(Tag::class);
    }

    public function addRoute(Route $route)
    {
        $this->addComponentFromRoute($route);

        foreach ($route->methods() as $method) {
            $this->paths[$route->uri()][$method] = $route->addResponses(ResponseHelper::get());
        }
    }

    public function addComponent(Schema $schema): self
    {
        $this->pushComponent($schema->type(), $schema->name(), $schema);

        return $this;
    }

    public function pushComponent(string $type, string $name, Schema $schema): self
    {
        $this->components[$type][$name] = $schema;

        return $this;
    }

    public function toArray()
    {
        return $this->process([
            'openapi' => static::OPENAPI,

            'info' => [
                'title'   => $this->name(),
                'version' => $this->version(),
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

    protected function addComponentFromRoute(Route $route): void
    {
        $schema = new SchemaEntity(
            $route->classname(),
            ['aaa']
        );

        $this->addComponent($schema);
    }

    protected function routes(): string
    {
        return Config::routesUri();
    }

    protected function process(array $array)
    {
        return array_map(function ($item) {
            if ($item instanceof Arrayable) {
                return $this->process($item->toArray());
            }

            if ($item instanceof BaseEntity) {
                return $this->process((array) $item);
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
