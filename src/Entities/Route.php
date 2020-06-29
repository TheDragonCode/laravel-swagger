<?php

namespace Helldar\LaravelSwagger\Entities;

use Helldar\LaravelSwagger\Contracts\Mapped;
use Helldar\LaravelSwagger\Contracts\Responsible;
use Helldar\LaravelSwagger\Contracts\Route as RouteContract;
use Helldar\LaravelSwagger\Facades\Config;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Route as RouteInstance;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as RouteCollection;
use Illuminate\Support\Str;

final class Route implements Arrayable, RouteContract, Mapped
{
    protected $route;

    protected $responses = [];

    public function __construct(RouteInstance $route = null)
    {
        $this->route = $route;
    }

    /**
     * @return \Illuminate\Support\Collection|\Helldar\LaravelSwagger\Entities\Route[]
     */
    public function mapped(): Collection
    {
        return $this->map(
            RouteCollection::getRoutes()
        );
    }

    /**
     * @param  \Illuminate\Routing\RouteCollectionInterface  $routes
     *
     * @return \Illuminate\Support\Collection|\Helldar\LaravelSwagger\Entities\Route[]
     */
    public function map(RouteCollectionInterface $routes): Collection
    {
        return collect($routes->getRoutes())
            ->mapInto(static::class);
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
        $url = trim($this->route->uri(), '/');

        if ($routes = trim(Config::get('routes'), '/*')) {
            $url = Str::before($url, $routes);
        }

        return Str::start($url, '/');
    }

    public function methods(): array
    {
        return $this->route->methods();
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function toArray()
    {
        return [
            'summary'     => 'Summary',
            'description' => 'Description',
            'tags'        => $this->tags(),
            'operationId' => $this->getOperationId(),
            'parameters'  => [],
            'responses'   => $this->responses(),
        ];
    }

    public function responses(): array
    {
        return $this->responses;
    }

    public function addResponse(Responsible $response)
    {
        $this->responses[$response->code()] = $response;
    }

    public function addResponses(array $responses)
    {
        foreach ($responses as $response) {
            $this->addResponse($response);
        }

        return $this;
    }

    protected function getOperationId(): string
    {
        return Str::random();
    }

    protected function tags(): array
    {
        $base_namespace = 'App\Http\Controllers';
        $controller     = Arr::get($this->route->action, 'controller');

        return Str::of($controller)
            ->before('@')
            ->after($base_namespace)
            ->explode('\\')
            ->filter()
            ->values()
            ->map(function ($item) {
                return Str::of($item)
                    ->kebab()
                    ->replace('controller', '')
                    ->replace('-', ' ')
                    ->trim()
                    ->title();
            })
            ->toArray();
    }
}
