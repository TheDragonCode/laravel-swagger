<?php

namespace Helldar\LaravelSwagger\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class Parameter extends BaseModel
{
    protected $value;

    public function __construct(string $parameter)
    {
        $this->value = $parameter;
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
        preg_match_all('/({[^}]+})/', $this->value, $matches);

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
