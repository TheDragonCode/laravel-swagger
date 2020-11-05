<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Contracts\Swagger as Contract;

final class Swagger implements Contract
{
    public function toArray()
    {
        return [];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
