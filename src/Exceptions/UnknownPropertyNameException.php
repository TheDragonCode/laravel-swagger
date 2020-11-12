<?php

namespace Helldar\LaravelSwagger\Exceptions;

use Exception;

final class UnknownPropertyNameException extends Exception
{
    public function __construct(string $key)
    {
        $message = 'Unknown property name: ' . $key;

        parent::__construct($message);
    }
}
