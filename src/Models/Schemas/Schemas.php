<?php

namespace Helldar\LaravelSwagger\Models\Schemas;

use Helldar\LaravelSwagger\Contracts\Schemas\Schema;
use Helldar\LaravelSwagger\Exceptions\UnknownSchemaException;

final class Schemas
{
    protected static $instances = [];

    public static function all(): array
    {
        return static::$instances;
    }

    public static function add(Schema $schema)
    {
        if (! isset(static::$instances[$schema->getKey()])) {
            static::$instances[$schema->getKey()] = $schema;
        }
    }

    public static function get(string $class): Schema
    {
        static::check($class);

        return static::$instances[md5($class)];
    }

    /**
     * @param $schema
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    protected static function check($schema): void
    {
        $class = is_string($schema) ? $schema : $schema->getKey();
        $key   = md5($class);

        if (! isset(static::$instances[$key])) {
            throw new UnknownSchemaException($schema);
        }
    }
}
