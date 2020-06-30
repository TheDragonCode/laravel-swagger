<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Entities\Route as RouteEntity;
use Helldar\LaravelSwagger\Entities\SecuritySchema;
use Helldar\LaravelSwagger\Exceptions\SwaggerException;
use Helldar\LaravelSwagger\Facades\Config;
use Helldar\LaravelSwagger\Facades\Route;
use Helldar\Support\Facades\Directory;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

final class Generator
{
    protected $swagger;

    protected $path;

    protected $filename;

    public function __construct(Swagger $swagger, string $path, string $filename)
    {
        $this->swagger  = $swagger;
        $this->path     = $path;
        $this->filename = $filename;
    }

    public function generate()
    {
        $this->prepareDirectory()
            ->setSecuritySchemes()
            ->setRoutes()
            ->saveJson()
            ->saveYaml();
    }

    protected function prepareDirectory(): self
    {
        if (File::exists($this->path) && ! is_writable($this->path)) {
            throw new SwaggerException('Documentation storage directory is not writable');
        }

        Directory::make($this->path);

        return $this;
    }

    protected function setSecuritySchemes(): self
    {
        foreach (Config::securitySchemes() as $name => $schema) {
            $this->swagger->addComponent(
                SecuritySchema::make($name, $schema)
            );
        }

        return $this;
    }

    protected function setRoutes(): self
    {
        Route::mapped()->each(function (RouteEntity $route) {
            $this->swagger->addRoute($route);
        });

        return $this;
    }

    protected function saveJson(): self
    {
        File::put(
            $this->getFilename('json'),
            $this->swagger->toJson(JSON_PRETTY_PRINT ^ JSON_OBJECT_AS_ARRAY ^ JSON_UNESCAPED_UNICODE)
        );

        return $this;
    }

    protected function saveYaml(): self
    {
        $doc = Yaml::dump(
            $this->swagger->toArray(),
            20,
            4,
            Yaml::DUMP_OBJECT_AS_MAP ^ Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE
        );

        File::put(
            $this->getFilename('yaml'),
            $doc
        );

        return $this;
    }

    protected function getFilename(string $extension): string
    {
        $path = rtrim($this->path, '/');

        return $path . '/' . $this->filename . '-' . $this->swagger->version() . '.' . $extension;
    }
}
