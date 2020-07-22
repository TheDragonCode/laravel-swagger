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
        $filename = $this->configFilename();

        $this->publishes([
            __DIR__ . '/../config/' . $filename => $this->app->configPath($filename),
        ], 'config');
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/" . $this->configFilename(), Config::key());
    }

    protected function configFilename(): string
    {
        return Config::file();
    }
}
