<?php

namespace Helldar\LaravelSwagger\Models\Properties;

final class Address extends BaseProperty
{
    protected function userExample()
    {
        return $this->getFaker()->address;
    }
}
