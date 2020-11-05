<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelSwagger\Facades\Config;
use Illuminate\Support\Arr;

final class Server extends BaseModel
{
    protected $item;

    public function __construct(array $item)
    {
        $this->item = $item;
    }

    public function toArray()
    {
        return [
            'url' => $this->url(),

            'description' => $this->description(),
        ];
    }

    protected function url(): string
    {
        if ($uri = $this->getUri()) {
            return $this->getHost() . '/' . $uri;
        }

        return $this->getHost();
    }

    protected function description(): ?string
    {
        return Arr::get($this->item, 'description');
    }

    protected function getHost(): string
    {
        $value = Arr::get($this->item, 'url', 'http://localhost');

        return rtrim($value, '/');
    }

    protected function getUri(): ?string
    {
        $value = Config::routesUri();

        return $value !== '*' ? trim($value, '/') : null;
    }
}
