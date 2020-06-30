<?php

namespace Helldar\LaravelSwagger\Support;

use Helldar\LaravelSwagger\Exceptions\ConfigException;
use Illuminate\Support\Facades\Config as IlluminateConfig;

final class Config
{
    public const KEY = 'laravel-swagger';

    public function get($key, $default = null)
    {
        return IlluminateConfig::get($this->compileKey($key), $default);
    }

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\ConfigException
     *
     * @return string
     */
    public function title(): string
    {
        $this->checkForEmptiness('title');

        return $this->get('title');
    }

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\ConfigException
     *
     * @return string
     */
    public function version(): string
    {
        $this->checkForEmptiness('version');

        return $this->get('version');
    }

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\ConfigException
     *
     * @return string
     */
    public function routesUri(): string
    {
        $this->checkForEmptiness('routes.uri');

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

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\ConfigException
     *
     * @return array
     */
    public function servers(): array
    {
        $this->checkForEmptiness('servers');

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

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\ConfigException
     *
     * @return string
     */
    public function path(): string
    {
        $this->checkForEmptiness('path');

        return $this->get('path');
    }

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\ConfigException
     *
     * @return string
     */
    public function filename(): string
    {
        $this->checkForEmptiness('filename');

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

    protected function compileKey(string $key)
    {
        return static::KEY . '.' . $key;
    }

    /**
     * @param  string  $key
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\ConfigException
     */
    protected function checkForEmptiness(string $key): void
    {
        if (! $this->get($key)) {
            throw new ConfigException($this->compileKey($key));
        }
    }
}
