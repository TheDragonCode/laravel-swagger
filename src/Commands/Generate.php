<?php

namespace Helldar\LaravelSwagger\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

final class Generate extends Command
{
    protected $signature = 'swagger:generate';

    protected $description = 'Generating documentation for Swagger';

    public function handle()
    {
        foreach ($this->routes() as $route) {
            dd($route);
        }

        $this->info('nice');
    }

    protected function routes()
    {
        return Route::getRoutes();
    }
}
