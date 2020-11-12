<?php

namespace Helldar\LaravelSwagger\Models\Properties;

final class DateTime extends BaseProperty
{
    protected $attributes = [
        'type' => 'datetime',
    ];

    protected function userExample()
    {
        return $this->getFaker()->dateTime;
    }
}
