<?php

namespace Helldar\LaravelSwagger\Models\Properties\Concerns;

use Helldar\LaravelSwagger\Exceptions\UnknownPropertyNameException;
use Helldar\LaravelSwagger\Models\Properties\DateTime;
use Helldar\LaravelSwagger\Models\Properties\Double_;
use Helldar\LaravelSwagger\Models\Properties\Integer_;

trait Castable
{
    protected $casts = [
        'integer'  => Integer_::class,
        'double'   => Double_::class,
        'datetime' => DateTime::class,
    ];

    protected function hasCastablePrimitive(string $key): bool
    {
        return isset($this->casts[$key]);
    }

    /**
     * @param  string  $key
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownPropertyNameException
     *
     * @return string
     */
    protected function getCast(string $key): string
    {
        if (! $this->hasCastablePrimitive($key)) {
            throw new UnknownPropertyNameException($key);
        }

        return $this->casts[$key];
    }
}
