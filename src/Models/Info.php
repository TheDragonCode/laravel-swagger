<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelSwagger\Facades\Config;

final class Info extends BaseModel
{
    public function toArray()
    {
        return [
            'title'   => $this->title(),
            'version' => $this->version(),
        ];
    }

    protected function title(): string
    {
        return Config::title() ?: 'Laravel';
    }

    protected function version(): string
    {
        return Config::version();
    }
}
