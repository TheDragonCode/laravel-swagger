<?php

namespace Helldar\LaravelSwagger\Models;

use Illuminate\Support\Arr;

final class Parameters extends BaseModel
{
    protected $uri;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    public function toArray()
    {
        $result = [];

        foreach ($this->matches() as $match) {
            $result[] = Parameter::make($match);
        }

        return $result;
    }

    protected function matches(): array
    {
        preg_match_all('/({[^}]+})/', $this->uri, $matches);

        return Arr::first($matches);
    }
}
