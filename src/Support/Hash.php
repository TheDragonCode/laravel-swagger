<?php

namespace Helldar\LaravelSwagger\Support;

final class Hash
{
    public function make($object): string
    {
        return $this->salt(
            md5($this->resolve($object))
        );
    }

    protected function salt(string $hash): string
    {
        return 'h' . $hash;
    }

    protected function resolve($object): string
    {
        return is_string($object) ? $object : get_class($object);
    }
}
