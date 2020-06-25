<?php

namespace Helldar\LaravelSwagger;

use Helldar\LaravelSwagger\Commands\Generate;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->bootCommands();
    }

    protected function bootCommands(): void
    {
        $this->commands([
            Generate::class,
        ]);
    }
}
