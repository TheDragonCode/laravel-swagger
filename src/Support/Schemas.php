<?php

namespace Helldar\LaravelSwagger\Support;

use Helldar\LaravelSwagger\Contracts\Schemas\Schema;
use Helldar\LaravelSwagger\Exceptions\UnknownSchemaException;
use Helldar\LaravelSwagger\Facades\Hash;

final class Schemas
{
    /** @var \Helldar\LaravelSwagger\Contracts\Schemas\Schema[] */
    protected static $instances = [];

    /**
     * @return \Helldar\LaravelSwagger\Contracts\Schemas\Schema[]
     */
    public static function all(): array
    {
        return static::$instances;
    }

    /**
     * @param  \Helldar\LaravelSwagger\Contracts\Schemas\Schema|string  $schema
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    public static function add($schema): void
    {
        $key = static::getKey($schema);

        if (! isset(static::$instances[$key])) {
            static::$instances[$key] = static::resolve($schema);
        }
    }

    /**
     * @param  string  $class
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     *
     * @return \Helldar\LaravelSwagger\Contracts\Schemas\Schema
     */
    public static function get(string $class): Schema
    {
        static::check($class);

        $key = Hash::make($class);

        return static::$instances[$key];
    }

    /**
     * @param $schema
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    protected static function check($schema): void
    {
        $key = static::getKey($schema);

        if (! isset(static::$instances[$key])) {
            throw new UnknownSchemaException($schema);
        }
    }

    /**
     * @param  \Helldar\LaravelSwagger\Contracts\Schemas\Schema|string  $schema
     *
     * @return string
     */
    protected static function getKey($schema): string
    {
        return is_string($schema)
            ? Hash::make($schema)
            : $schema->getKey();
    }

    /**
     * @param  \Helldar\LaravelSwagger\Contracts\Schemas\Schema|string  $schema
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     *
     * @return \Helldar\LaravelSwagger\Contracts\Schemas\Schema
     */
    protected static function resolve($schema): Schema
    {
        $instance = is_string($schema) ? new $schema() : $schema;

        if (! is_subclass_of($instance, Schema::class)) {
            throw new UnknownSchemaException($instance);
        }

        return $instance;
    }
}
