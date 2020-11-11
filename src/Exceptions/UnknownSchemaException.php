<?php

namespace Helldar\LaravelSwagger\Exceptions;

final class UnknownSchemaException extends \Exception
{
    public function __construct(string $schema)
    {
        parent::__construct(
            'Unknown schema: ' . $schema
        );
    }
}
