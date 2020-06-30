<?php

namespace Helldar\LaravelSwagger\Entities;

use Illuminate\Support\Str;

final class Tag extends BaseEntity
{
    public $name;

    public $description;

    public function __construct(string $name)
    {
        $this->name($name);
        $this->description($name);
    }

    protected function name(string $name): void
    {
        $this->name = Str::of($name)
            ->trim()
            ->title()
            ->singular();
    }

    protected function description(string $name): void
    {
        $name = Str::of($name)
            ->trim()
            ->title()
            ->plural();

        $this->description = 'Everything about your ' . $name;
    }
}
