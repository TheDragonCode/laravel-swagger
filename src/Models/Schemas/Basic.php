<?php

namespace Helldar\LaravelSwagger\Models\Schemas;

final class Basic extends BaseSchema
{
    protected $attributes = [
        'description' => 'A set of basic properties.',
    ];

    public function __construct()
    {
        $this->fromConfig();
    }

    protected function pushProperty(string $property, string $key): void
    {
        /** @var \Helldar\LaravelSwagger\Contracts\Schemas\Property $item */
        $item = new $property;

        $item->setKey($key);

        $this->addProperty($item);
    }

    protected function fromConfig(): void
    {
        foreach ($this->presetProperties() as $key => $class) {
            $this->pushProperty($class, $key);
        }
    }

    protected function presetProperties(): array
    {
        return config('laravel-swagger.schema.properties', []);
    }
}
