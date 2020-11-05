<?php

namespace Helldar\LaravelSwagger\Concerns;

use Illuminate\Contracts\Support\Arrayable as ArrayContract;

trait Arrayable
{
    public function convertToArray(array $array): array
    {
        foreach ($array as &$item) {
            if ($item instanceof ArrayContract) {
                $item = $item->toArray();
            }

            if (is_array($item)) {
                $item = $this->convertToArray($item);
            }
        }

        return $array;
    }
}
