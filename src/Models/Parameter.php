<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelSwagger\Services\Reference;
use Illuminate\Support\Str;

final class Parameter extends BaseModel
{
    protected $attributes = [
        'in' => 'path',
    ];

    /**
     * @param  string  $parameter
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    public function __construct(string $parameter)
    {
        $this->setName($parameter);
        $this->setRequired($parameter);
        $this->setSchemaReference();
    }

    protected function setName(string $parameter): void
    {
        $this->setAttribute('name', trim($parameter, '{}?'));
    }

    protected function setRequired(string $parameter): void
    {
        $this->setAttribute('required', ! Str::contains($parameter, '?'));
    }

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    protected function setSchemaReference(): void
    {
        $name = $this->getAttribute('name');

        $this->setAttribute('schema.$ref', Reference::make()->basic($name));
    }
}
