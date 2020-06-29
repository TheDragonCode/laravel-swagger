<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Entities\Response;
use Helldar\LaravelSwagger\Facades\Config;
use Illuminate\Support\Arr;

final class Responses
{
    protected $items = [];

    public function get(): array
    {
        if (! $this->items) {
            foreach ($this->getClasses() as $code => $item) {
                $this->items[$code] = Response::make(
                    $code,
                    Arr::get($item, 'name'),
                    Arr::get($item, 'description')
                );
            }
        }

        return $this->items;
    }

    protected function getClasses(): array
    {
        return Config::get('exceptions', []);
    }
}
