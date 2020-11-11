<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelRoutesCore\Facades\Annotation;
use Helldar\LaravelRoutesCore\Models\Route;
use Helldar\LaravelSwagger\Contracts\Pathable;
use Illuminate\Support\Str;

final class Path extends BaseModel implements Pathable
{
    /** @var \Helldar\LaravelRoutesCore\Models\Route */
    protected $route;

    /** @var string */
    protected $start_uri;

    public function __construct(Route $route, string $start_uri)
    {
        $this->route     = $route;
        $this->start_uri = $start_uri;
    }

    public function toArray()
    {
        $result = [];
        $data   = $this->get();

        foreach ($this->route->getMethods() as $method) {
            $result[$method] = $data;
        }

        return [$this->path() => $result];
    }

    protected function get()
    {
        return [
            'tags'        => [],
            'summary'     => $this->summary(),
            'description' => $this->description(),
            'operationId' => $this->operationId(),
            'parameters'  => $this->parameters(),
            'responses'   => $this->responses(),
        ];
    }

    protected function path(): string
    {
        $uri = Str::after(
            $this->route->getPath(),
            $this->start_uri
        );

        return '/' . trim($uri, '/');
    }

    protected function summary(): ?string
    {
        return Annotation::summary(
            $this->route->getAction()
        );
    }

    protected function description(): ?string
    {
        return Annotation::description(
            $this->route->getAction()
        );
    }

    protected function operationId(): string
    {
        return md5($this->route->getAction());
    }

    protected function parameters(): Parameters
    {
        return Parameters::make($this->route->getPath());
    }

    protected function responses()
    {
        return $this->route->getExceptions();
    }
}
