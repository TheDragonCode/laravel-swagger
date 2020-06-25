<?php

namespace Helldar\LaravelSwagger;

use Helldar\LaravelSwagger\Commands\Generate;
use Helldar\LaravelSwagger\Support\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->bootCommands();
        $this->bootPublishes();
    }

    public function register(): void
    {
        $this->registerConfig();
    }

    protected function bootCommands(): void
    {
        $this->commands([
            Generate::class,
        ]);
    }

    protected function bootPublishes(): void
    {
        $key = Config::KEY;

        $this->publishes([
            __DIR__ . "/../config/{$key}.php" => $this->app->configPath("{$key}.php"),
        ], 'config');
    }

    protected function registerConfig()
    {
        $key = Config::KEY;

        $this->mergeConfigFrom(__DIR__ . "/../config/{$key}.php", $key);
    }
}
