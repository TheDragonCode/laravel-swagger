<?php

namespace Helldar\LaravelSwagger\Support;

use Helldar\LaravelSwagger\Exceptions\ConfigException;
use Helldar\LaravelSwagger\Exceptions\UnknownConfigKeyException;
use Illuminate\Support\Facades\Config as IlluminateConfig;
use Illuminate\Support\Str;

final class Config
{
    public const KEY = 'laravel-swagger';

    protected $check_keys = ['title', 'version', 'routes.uri', 'servers', 'path', 'filename'];

    /**
     * @param $key
     * @param $arguments
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\ConfigException
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownConfigKeyException
     * @return mixed
     */
    public function __call($key, $arguments)
    {
        $key = $this->prepareKey($key);

        if (! $this->has($key)) {
            throw new UnknownConfigKeyException($this->compileKey($key));
        }

        if (in_array($key, $this->check_keys)) {
            $this->checkForEmptiness($key);
        }

        return $this->get($key);
    }

    public function key(): string
    {
        return static::KEY;
    }

    public function file(): string
    {
        return static::KEY . '.php';
    }

    public function get(string $key, $default = null)
    {
        return IlluminateConfig::get($this->compileKey($key), $default);
    }

    public function has(string $key): bool
    {
        return IlluminateConfig::has($this->compileKey($key));
    }

    protected function compileKey(string $key)
    {
        return static::KEY . '.' . $key;
    }

    protected function prepareKey(string $key)
    {
        return Str::snake($key, '.');
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
