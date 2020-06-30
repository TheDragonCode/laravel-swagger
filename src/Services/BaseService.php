<?php

namespace Helldar\LaravelSwagger\Services;

use DirectoryIterator;
use Helldar\LaravelSwagger\Contracts\Grabeable;
use Helldar\Support\Facades\Directory;
use Illuminate\Container\Container;

abstract class BaseService implements Grabeable
{
    /** @var \DirectoryIterator */
    protected $files;

    protected function appPath(string $path = '')
    {
        return $this->app()->basePath(
            DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $path
        );
    }

    /**
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\Foundation\Application
     */
    protected function app()
    {
        return Container::getInstance();
    }

    protected function files(): DirectoryIterator
    {
        if (! $this->files) {
            $this->files = Directory::all(
                $this->appPath()
            );
        }

        return $this->files;
    }

    protected function search(string $instance_of)
    {
        $items = [];

        foreach ($this->files() as $directory) {
            $items[] = $directory;
        }

        return $items;
    }
}
