<?php

namespace Helldar\LaravelSwagger\Exceptions;

use Exception;

final class UnknownPropertyNameException extends Exception
{
    public function __construct(string $key)
    {
        parent::__construct(
            'Unknown property name: ' . $key
        );
    }
}
