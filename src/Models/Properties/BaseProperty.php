<?php

namespace Helldar\LaravelSwagger\Models\Properties;

use Helldar\LaravelSwagger\Contracts\Schemas\Property;
use Helldar\LaravelSwagger\Models\BaseModel;
use Helldar\LaravelSwagger\Models\Properties\Concerns\Faker;

abstract class BaseProperty extends BaseModel implements Property
{
    use Faker;

    public $key;

    protected $attributes = [
        'type' => 'string',
    ];

    public function __construct()
    {
        $this->makeExample();
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): Property
    {
        $this->key = $key;

        return $this;
    }

    public function getType(): string
    {
        return $this->getAttribute('type');
    }

    public function setType(string $type): Property
    {
        $this->setAttribute('type', $type);

        return $this;
    }

    public function getExample()
    {
        return $this->getAttribute('example');
    }

    public function setExample($value): Property
    {
        $this->setAttribute('example', $value);

        return $this;
    }
}
