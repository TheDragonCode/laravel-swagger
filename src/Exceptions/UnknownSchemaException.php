<?php

namespace Helldar\LaravelSwagger\Exceptions;

final class UnknownSchemaException extends \Exception
{
    public function __construct($schema)
    {
        $schema = is_string($schema) ? $schema : get_class($schema);

        parent::__construct(
            __('Unknown schema: :schema.', compact('schema'))
        );
    }
}
