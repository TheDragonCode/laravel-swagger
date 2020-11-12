<?php

namespace Helldar\LaravelSwagger\Exceptions;

use Exception;

final class UnknownSchemaException extends Exception
{
    public function __construct($schema)
    {
        $schema = is_string($schema) ? $schema : get_class($schema);

        $message = 'Unknown schema: ' . $schema;

        parent::__construct($message);
    }
}
