<?php

namespace Helldar\LaravelSwagger\Models\Schemas;

use Helldar\LaravelSwagger\Facades\Config;

final class Basic extends BaseSchema
{
    protected $attributes = [
        'type'        => 'object',
        'description' => self::class,
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
        return array_merge($this->casts, Config::schemaProperties());
    }
}
