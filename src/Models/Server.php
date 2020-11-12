<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelSwagger\Facades\Config;
use Illuminate\Support\Arr;

final class Server extends BaseModel
{
    public function __construct(array $item)
    {
        $this->setDescription($item);
        $this->setUrl($item);
    }

    protected function setDescription(array $item): void
    {
        $value = Arr::get($item, 'description');

        $this->setAttribute('description', $value);
    }

    protected function setUrl(array $item): void
    {
        $this->setAttribute('url', $this->url($item));
    }

    protected function url(array $item): string
    {
        if ($uri = $this->getUri()) {
            return $this->getHost($item) . '/' . $uri;
        }

        return $this->getHost($item);
    }

    protected function getHost(array $item): string
    {
        $value = Arr::get($item, 'url', 'http://localhost');

        return rtrim($value, '/');
    }

    protected function getUri(): ?string
    {
        $value = Config::routesUri();

        return $value !== '*' ? trim($value, '/') : null;
    }
}
