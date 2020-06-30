<?php

namespace Helldar\LaravelSwagger\Contracts;

interface Responsible
{
    public function code(): int;

    public function description(): string;

    public function content(): array;
}
