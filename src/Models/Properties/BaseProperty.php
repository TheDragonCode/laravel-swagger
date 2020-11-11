<?php

namespace Helldar\LaravelSwagger\Models\Properties;

use Helldar\LaravelSwagger\Contracts\Schemas\Property;
use Helldar\LaravelSwagger\Models\Properties\Concerns\Faker;

abstract class BaseProperty implements Property
{
    use Faker;

    public $key;

    public $type;

    public $example;

    protected $replace = false;

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
        return $this->type;
    }

    public function setType(string $type): Property
    {
        $this->type = $type;

        return $this;
    }

    public function getExample()
    {
        return $this->example;
    }

    public function setExample($value): Property
    {
        $this->example = $value;

        return $this;
    }

    public function toArray()
    {
        if ($this->replace) {
            return $this->custom();
        }

        return array_merge([
            'type'    => $this->type,
            'example' => $this->example,
        ], $this->custom());
    }

    protected function custom(): array
    {
        $items = [];

        if (property_exists($this, 'format')) {
            $items['format'] = $this->format;
        }

        return $items;
    }
}
