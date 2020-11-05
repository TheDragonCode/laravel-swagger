<?php

namespace Helldar\LaravelSwagger\Commands;

use Helldar\LaravelRoutesCore\Facades\Routes;
use Helldar\LaravelSwagger\Facades\Config;
use Helldar\LaravelSwagger\Facades\Files;
use Helldar\LaravelSwagger\Services\Swagger;
use Illuminate\Console\Command;

final class Generate extends Command
{
    protected $signature = 'swagger:generate';

    protected $description = 'Generating documentation for Swagger';

    protected $routes = [];

    protected $requests = [];

    protected $exceptions = [];

    /** @var \Helldar\LaravelSwagger\Contracts\Swagger */
    protected $swagger;

    public function handle(Swagger $swagger)
    {
        $this->swagger = $swagger;

        $this->info('Collecting routes...');
        $this->routes();

        $this->info('Collecting requests...');
        $this->requests();

        $this->info('Storing data...');
        Files::swagger($this->swagger)->storeAll();

        $this->info('Documentation generated successfully.');
    }

    protected function routes(): void
    {
        $this->routes = Routes::hideMethods(Config::routesHideMethods())
            ->hideMatching(Config::routesHideMatching())
            ->get();
    }

    protected function requests(): void
    {

    }

    protected function exceptions(): void
    {
        $this->exceptions = Config::exceptions();
    }
}
