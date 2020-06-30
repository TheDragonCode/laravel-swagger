<?php

namespace Helldar\LaravelSwagger\Exceptions;

use Exception;

final class ConfigException extends Exception
{
    public function __construct(string $key)
    {
        parent::__construct("The value of the '{$key}' configuration key cannot be empty.", 500);
    }
}
