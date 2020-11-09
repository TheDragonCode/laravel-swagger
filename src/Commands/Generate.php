<?php

namespace Helldar\LaravelSwagger\Commands;

use Helldar\LaravelRoutesCore\Facades\Routes;
use Helldar\LaravelRoutesCore\Models\Route;
use Helldar\LaravelSwagger\Contracts\Swagger as SwaggerContract;
use Helldar\LaravelSwagger\Facades\Config;
use Helldar\LaravelSwagger\Facades\Files;
use Helldar\LaravelSwagger\Models\Path;
use Helldar\LaravelSwagger\Services\Swagger;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class Generate extends Command
{
    protected $signature = 'swagger:generate '
    . ' {--ver=}'
    . ' {--uri=}';

    protected $description = 'Generating documentation for Swagger';

    public function handle(Swagger $swagger)
    {
        $swagger->setVersion($this->version());

        $this->info('Collecting routes...');
        $routes = $this->routes();

        $this->info('Collecting requests...');
        $requests = $this->requests();

        $this->info('Collecting exceptions...');
        $exceptions = $this->exceptions();

        $this->info('Filling data...');
        $this->fill($swagger, $routes, $requests, $exceptions);

        $this->info('Storing data...');
        $this->store($swagger);

        $this->info('Documentation generated successfully.');
    }

    /**
     * @return \Illuminate\Support\Collection|\Helldar\LaravelRoutesCore\Models\Route[]
     */
    protected function routes(): Collection
    {
        return Routes::setHideMethods(Config::routesHideMethods())
            ->setHideMatching(Config::routesHideMatching())
            ->collection();
    }

    protected function requests(): array
    {
        return [];
    }

    protected function exceptions(): array
    {
        return Config::exceptions();
    }

    protected function store(SwaggerContract $swagger): void
    {
        Files::swagger($swagger)->storeAll();
    }

    /**
     * @param  \Helldar\LaravelSwagger\Contracts\Swagger  $swagger
     * @param  \Illuminate\Support\Collection|\Helldar\LaravelRoutesCore\Models\Route[]  $routes
     * @param  array  $requests
     * @param  array  $exceptions
     */
    protected function fill(SwaggerContract $swagger, Collection $routes, array $requests, array $exceptions): void
    {
        $uri = ltrim($this->uri(), '/');

        $routes->each(static function (Route $route) use ($swagger, $uri) {
            $path = ltrim($route->getPath(), '/');

            if (Str::startsWith($path, $uri)) {
                $swagger->addPath(
                    Path::make($route, $uri)
                );
            }
        });
    }

    protected function version(): string
    {
        return $this->option('ver') ?: Config::version();
    }

    protected function uri(): string
    {
        return $this->option('uri') ?: Config::routesUri();
    }
}
