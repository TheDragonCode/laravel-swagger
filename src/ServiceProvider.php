<?php

namespace Helldar\LaravelSwagger;

use Helldar\LaravelSwagger\Commands\Generate;
use Helldar\LaravelSwagger\Facades\Config;
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
        $filename = Config::file();

        $this->publishes([
            __DIR__ . '/../config/' . $filename => $this->app->configPath($filename),
        ], 'config');
    }

    protected function registerConfig()
    {
        $filename = Config::file();

        $this->mergeConfigFrom(__DIR__ . "/../config/" . $filename, Config::key());
    }
}
