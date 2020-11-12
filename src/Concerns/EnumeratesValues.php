<?php

namespace Helldar\LaravelSwagger\Concerns;

use Illuminate\Contracts\Support\Arrayable as ArrayContract;

trait EnumeratesValues
{
    public function arrayable(array $array): array
    {
        return array_map(function ($value) {
            $value = $value instanceof ArrayContract ? $value->toArray() : $value;

            if (is_array($value)) {
                $value = $this->arrayable($value);
            }

            return $value;
        }, $array);
    }
}
