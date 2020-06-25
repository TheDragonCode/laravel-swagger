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

    protected $swagger;

    public function __construct(Swagger $swagger)
    {
        parent::__construct();

        $this->swagger = $swagger;
    }

    public function handle()
    {
        foreach ($this->routes() as $route) {
            $this->swagger->addRoute($route);
        }

        $this->store();

        $this->info('nice');
    }

    protected function routes()
    {
        return Route::mapped();
    }

    protected function store()
    {
        File::store(
            base_path('foo.json'),
            json_encode($this->swagger->toArray(), JSON_PRETTY_PRINT)
        );
    }
}
