<?php

namespace Helldar\LaravelSwagger\Exceptions;

final class UnknownConfigKeyException extends \Exception
{
    public function __construct(string $key)
    {
        parent::__construct("Unknown configuration key ({$key})", 500);
    }
}
