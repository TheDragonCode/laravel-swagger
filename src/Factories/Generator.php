<?php

namespace Helldar\LaravelSwagger\Factories;

use Helldar\LaravelSwagger\Facades\Config;
use Helldar\LaravelSwagger\Services\Generator as GeneratorService;
use Helldar\LaravelSwagger\Services\Swagger;

final class Generator
{
    protected $swagger;

    public function __construct(Swagger $swagger)
    {
        $this->swagger = $swagger;
    }

    public function make(): GeneratorService
    {
        return new GeneratorService(
            $this->swagger,
            $this->path(),
            $this->filename()
        );
    }

    protected function path(): string
    {
        return Config::path();
    }

    protected function filename(): string
    {
        return Config::filename();
    }
}
