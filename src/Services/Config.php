<?php

namespace Helldar\LaravelSwagger\Services;

final class Config
{
    public const NAME = 'laravel-swagger';

    public function title(): string
    {
        return $this->get('title') ?: 'Laravel';
    }

    public function version(): string
    {
        return $this->get('version');
    }

    public function exceptions(): array
    {
        return $this->get('exceptions', []);
    }

    public function servers(): array
    {
        return $this->get('servers', []);
    }

    public function path(string $path = null): string
    {
        $dir = $this->get('path');

        return $path
            ? rtrim($dir, '/') . '/' . ltrim($path, '/')
            : $dir;
    }

    public function filename(string $extension = null): string
    {
        $filename = $this->get('filename');

        return $extension
            ? $filename . '.' . $extension
            : $filename;
    }

    public function routesUri(): string
    {
        return $this->get('routes.uri');
    }

    public function routesHideMethods(): array
    {
        return $this->get('routes.hide.methods', []);
    }

    public function routesHideMatching(): array
    {
        return $this->get('routes.hide.matching', []);
    }

    protected function get(string $key, $default = null)
    {
        return config(self::NAME . '.' . $key, $default);
    }
}
