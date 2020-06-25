<?php

namespace Helldar\LaravelSwagger\Commands;

use Helldar\LaravelSwagger\Facades\Route;
use Helldar\LaravelSwagger\Services\Swagger;
use Helldar\Support\Facades\File;
use Illuminate\Console\Command;

final class Generate extends Command
{
    protected $signature = 'swagger:generate';

    protected $description = 'Generating documentation for Swagger';

    public function handle(Swagger $swagger)
    {
        foreach ($this->routes() as $route) {
            $swagger->addRoute($route);
        }

        $this->store($swagger);

        $this->info('nice');
    }

    protected function routes()
    {
        return Route::mapped();
    }

    protected function store(Swagger $swagger)
    {
        File::store(
            base_path('foo.json'),
            json_encode($swagger->toArray(), JSON_PRETTY_PRINT)
        );
    }
}
