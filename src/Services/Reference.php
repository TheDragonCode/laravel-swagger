<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelRoutesCore\Traits\Makeable;
use Helldar\LaravelSwagger\Contracts\Schemas\Property;
use Helldar\LaravelSwagger\Contracts\Schemas\Schema;
use Helldar\LaravelSwagger\Models\Schemas\Basic;
use Helldar\LaravelSwagger\Support\Schemas;

final class Reference
{
    use Makeable;

    protected $object;

    protected $schema = '#/components/schemas/{schema}';

    protected $property = '#/components/schemas/{schema}/properties/{property}';

    /**
     * @param  \Helldar\LaravelSwagger\Contracts\Schemas\Schema  $schema
     * @param  \Helldar\LaravelSwagger\Contracts\Schemas\Property|null  $property
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     *
     * @return string
     */
    public function link(Schema $schema, Property $property = null): string
    {
        $this->pushSchema($schema);

        return is_null($property)
            ? $this->format($schema->getKey())
            : $this->format($schema->getKey(), $property->getKey());
    }

    /**
     * @param  string  $key
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     *
     * @return string
     */
    public function basic(string $key): string
    {
        $this->pushSchema(Basic::class);

        $schema = Schemas::get(Basic::class);

        return $this->link($schema, $schema->getProperty($key));
    }

    protected function format(string $schema, string $property = null): string
    {
        $template = is_null($property) ? $this->schema : $this->property;

        return str_replace(['{schema}', '{property}'], [$schema, $property], $template);
    }

    /**
     * @param  \Helldar\LaravelSwagger\Contracts\Schemas\Schema|string  $schema
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    protected function pushSchema($schema): void
    {
        Schemas::add($schema);
    }
}
