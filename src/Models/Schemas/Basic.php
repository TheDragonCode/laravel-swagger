<?php

namespace Helldar\LaravelSwagger\Models\Schemas;

use Helldar\LaravelSwagger\Models\Properties\Double_;
use Helldar\LaravelSwagger\Models\Properties\Integer_;
use Helldar\LaravelSwagger\Models\Properties\String_;

final class Basic extends BaseSchema
{
    public function __construct()
    {
        $this->pushProperty(String_::class, 'slug');
        $this->pushProperty(Integer_::class, 'integer');
        $this->pushProperty(Double_::class, 'double');

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
        foreach ($this->properties() as $key => $class) {
            $this->pushProperty($class, $key);
        }
    }

    protected function properties(): array
    {
        return config('laravel-swagger.schema.properties', []);
    }
}
