<?php

namespace Helldar\LaravelSwagger\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class Parameter extends BaseModel
{
    protected $values;

    public function __construct(string $parameters)
    {
        $this->values = $parameters;
    }

    public function toArray()
    {
        $result = [];

        foreach ($this->matches() as $match) {
            $result[] = $this->parse($match);
        }

        return $result;
    }

    protected function matches(): array
    {
        preg_match_all('/({[^}]+})/', $this->values, $matches);

        return Arr::first($matches);
    }

    protected function parse(string $value)
    {
        return [
            'name'     => trim($value, '{}?'),
            'in'       => 'path',
            'required' => ! Str::contains($value, '?'),
        ];
    }
}
