<?php

namespace Helldar\LaravelSwagger\Models;

use Illuminate\Support\Arr;

final class Parameters extends BaseModel
{
    public function __construct(string $uri)
    {
        $this->setMatches($uri);
    }

    protected function setMatches(string $uri): void
    {
        foreach ($this->matches($uri) as $match) {
            $this->pushAttribute(
                Parameter::make($match)
            );
        }
    }

    protected function matches(string $uri): array
    {
        preg_match_all('/({[^}]+})/', $uri, $matches);

        return Arr::first($matches);
    }
}
