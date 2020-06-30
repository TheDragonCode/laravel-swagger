<?php

namespace Helldar\LaravelSwagger\Support;

use Illuminate\Support\Facades\Config as IlluminateConfig;

final class Config
{
    public const KEY = 'laravel-swagger';

    public function get($key, $default = null)
    {
        return IlluminateConfig::get($this->compileKey($key), $default);
    }

    public function title(): string
    {
        return $this->get('title');
    }

    public function version(): string
    {
        return $this->get('version');
    }

    public function routesUri(): string
    {
        return $this->get('routes.uri');
    }

    public function routesHideMethods(): array
    {
        return $this->get('routes.hide.methods');
    }

    public function routesHideMatching(): array
    {
        return $this->get('routes.hide.matching');
    }

    public function servers(): array
    {
        return $this->get('servers');
    }

    public function securitySchemes(): array
    {
        return $this->get('security_schemes');
    }

    public function exceptions(): array
    {
        return $this->get('exceptions');
    }

    public function path(): string
    {
        return $this->get('path');
    }

    public function filename(): string
    {
        return $this->get('filename');
    }

    public function key(): string
    {
        return static::KEY;
    }

    public function file(): string
    {
        return static::KEY . '.php';
    }

    protected function compileKey($key)
    {
        return static::KEY . '.' . $key;
    }
}
