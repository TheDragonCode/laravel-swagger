<?php

namespace Helldar\LaravelSwagger;

use Helldar\LaravelSwagger\Commands\Generate;
use Helldar\LaravelSwagger\Models\Schemas\Basic;
use Helldar\LaravelSwagger\Models\Schemas\Schemas;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    protected $config_key = 'laravel-swagger';

    public function boot()
    {
        $this->bootCommands();
        $this->bootPublishes();

        $this->bootSchemas();
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
        $this->mergeConfigFrom(__DIR__ . "/../config/" . $this->configFilename(), $this->config_key);
    }

    protected function configFilename(): string
    {
        return $this->config_key . '.php';
    }

    protected function bootSchemas()
    {
        Schemas::add(new Basic());
    }
}
