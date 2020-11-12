<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelRoutesCore\Facades\Annotation;
use Helldar\LaravelRoutesCore\Models\Route;
use Helldar\LaravelSwagger\Contracts\Pathable;
use Helldar\LaravelSwagger\Facades\Hash;
use Illuminate\Support\Str;

final class Path extends BaseModel implements Pathable
{
    protected $path;

    public function __construct(Route $route, string $start_uri)
    {
        $this->setPath($route, $start_uri);

        $this->each(
            $route->getMethods(),
            $this->getData($route)
        );
    }

    public function toArray()
    {
        return [$this->path => $this->getAttributes()];
    }

    protected function getData(Route $route): array
    {
        $tags        = $this->getTags($route);
        $summary     = $this->getSummary($route);
        $description = $this->getDescription($route);
        $operationId = $this->getOperationId($route);
        $parameters  = $this->getParameters($route);
        $responses   = $this->getResponses($route);

        return compact('tags', 'summary', 'description', 'operationId', 'parameters', 'responses');
    }

    protected function each(array $methods, array $data): void
    {
        foreach ($methods as $method) {
            $this->setAttribute($method, $data);
        }
    }

    protected function setPath(Route $route, string $start_uri): void
    {
        $uri = Str::after($route->getPath(), $start_uri);

        $this->path = '/' . trim($uri, '/');
    }

    protected function getTags(Route $route): array
    {
        return [];
    }

    protected function getSummary(Route $route): string
    {
        return Annotation::summary(
            $route->getAction()
        ) ?: __('Empty summary.');
    }

    protected function getDescription(Route $route): string
    {
        return Annotation::description(
            $route->getAction()
        ) ?: __('Empty description.');
    }

    protected function getOperationId(Route $route): string
    {
        return Hash::make($route->getAction());
    }

    protected function getParameters(Route $route): Parameters
    {
        return Parameters::make($route->getPath());
    }

    protected function getResponses(Route $route): array
    {
        $responses = array_merge($this->getSuccessResponses($route), $this->getExceptionResponses($route));

        ksort($responses);

        return $responses;
    }

    protected function getSuccessResponses(Route $route): array
    {
        return [];
    }

    protected function getExceptionResponses(Route $route): array
    {
        return $route->getExceptions()
            ->mapInto(Response::class)
            ->toArray();
    }
}
