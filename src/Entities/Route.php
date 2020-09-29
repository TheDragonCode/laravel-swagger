<?php

namespace Helldar\LaravelSwagger\Entities;

use Helldar\LaravelSwagger\Contracts\Mappable;
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
use ReflectionParameter;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

final class Route extends BaseEntity implements Arrayable, RouteContract, Mappable
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
        $matching = Config::routesHideMatching();
        $base     = Str::finish(Config::routesUri(), '*');

        return collect($routes->getRoutes())
            ->filter(function (RouteInstance $route) use ($base, $matching) {
                $matched    = Str::is($matching, $route->uri());
                $allow      = Str::is($base, $route->uri());
                $is_closure = Str::is('Closure', $route->getActionMethod());

                return ! $is_closure && ! $matched && $allow;
            })
            ->mapInto(static::class);
    }

    public function middleware(): array
    {
        return array_filter($this->route->getAction('middleware'), static function ($value) {
            return $value !== 'api';
        });
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
        return Str::of($this->route->uri())
            ->after(Config::routesUri())
            ->replace('?', '')
            ->start('/');
    }

    public function methods(): array
    {
        $hide = Config::routesHideMethods();

        return collect($this->route->methods())
            ->filter(function ($method) use ($hide) {
                return ! Str::of($method)
                    ->lower()
                    ->contains($hide);
            })
            ->map(function ($method) {
                return Str::lower($method);
            })->toArray();
    }

    public function summary(): ?string
    {
        return Reflection::make($this->classname(), $this->action())->summary();
    }

    public function description(): ?string
    {
        return Reflection::make($this->classname(), $this->action())->description();
    }

    public function security(): array
    {
        $schemes = Config::securitySchemes();
        $items   = [];

        foreach ($this->middleware() as $item) {
            $item = Str::after($item, ':');

            if (array_key_exists($item, $schemes)) {
                $items[$item] = [];
            }
        }

        return $items;
    }

    public function toArray()
    {
        return $this->filter([
            'summary'     => $this->summary(),
            'description' => $this->description(),
            'tags'        => $this->tags(),
            'operationId' => $this->getOperationId(),
            'parameters'  => $this->parameters(),
            'responses'   => $this->responses(),
            'security'    => $this->security(),
        ]);
    }

    public function responses(): array
    {
        ksort($this->responses);

        return $this->responses;
    }

    public function parameters(): array
    {
        $method = Reflection::make($this->classname(), $this->action())->getReflection();

        return collect($method->getParameters())
            ->filter(function (ReflectionParameter $parameter) {
                return ! is_subclass_of(optional($parameter->getClass())->getName(), SymfonyRequest::class);
            })
            ->values()
            ->map(function (ReflectionParameter $parameter) {
                $docblock = Reflection::make($this->classname(), $this->action())->getDocBlock();

                return Parameter::make($parameter, $docblock);
            })
            ->toArray();
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

    public function tags(): array
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
                    ->title()
                    ->singular();
            })
            ->toArray();
    }

    protected function getOperationId(): string
    {
        return Str::random();
    }
}
