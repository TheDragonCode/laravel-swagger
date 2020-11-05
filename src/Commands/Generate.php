<?php

namespace Helldar\LaravelSwagger\Commands;

use Helldar\LaravelRoutesCore\Facades\Routes;
use Helldar\LaravelSwagger\Contracts\Swagger as SwaggerContract;
use Helldar\LaravelSwagger\Facades\Config;
use Helldar\LaravelSwagger\Facades\Files;
use Helldar\LaravelSwagger\Models\Path;
use Helldar\LaravelSwagger\Services\Swagger;
use Illuminate\Console\Command;

final class Generate extends Command
{
    protected $signature = 'swagger:generate';

    protected $description = 'Generating documentation for Swagger';

    public function handle(Swagger $swagger)
    {
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
     * @return \Helldar\LaravelRoutesCore\Models\Route[]
     */
    protected function routes(): array
    {
        return Routes::hideMethods(Config::routesHideMethods())
            ->hideMatching(Config::routesHideMatching())
            ->get();
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
     * @param  \Helldar\LaravelRoutesCore\Models\Route[]  $routes
     * @param  array  $requests
     * @param  array  $exceptions
     */
    protected function fill(SwaggerContract $swagger, array $routes, array $requests, array $exceptions): void
    {
        foreach ($routes as $route) {
            $path = new Path($route);

            $swagger
                ->addPath($path);
        }
    }
}
