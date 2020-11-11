<?php

namespace Helldar\LaravelSwagger\Models\Schemas;

use Helldar\LaravelRoutesCore\Traits\Makeable;
use Helldar\LaravelSwagger\Contracts\Schemas\Property;
use Helldar\LaravelSwagger\Contracts\Schemas\Schema;

final class Reference
{
    use Makeable;

    protected $object;

    protected $schema = '#/components/schemas/{schema}';

    protected $property = '#/components/schemas/{schema}/properties/{property}';

    public function link(Schema $schema, Property $property = null): string
    {
        return $this->format(
            $schema->getKey(),
            $property->getKey() ?? null
        );
    }

    public function basic(string $key): string
    {
        $schema = Schemas::get(Basic::class);

        return $this->link($schema, $schema->getProperty($key));
    }

    protected function format(string $schema, string $property = null): string
    {
        $template = is_null($property) ? $this->schema : $this->property;

        return str_replace(['{schema}', '{property}'], [$schema, $property], $template);
    }
}
