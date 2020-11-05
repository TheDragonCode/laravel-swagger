<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Concerns\Arrayable;
use Helldar\LaravelSwagger\Contracts\Pathable;
use Helldar\LaravelSwagger\Contracts\Swagger as Contract;
use Helldar\LaravelSwagger\Facades\Config as ConfigFacade;
use Helldar\LaravelSwagger\Models\Info;
use Helldar\LaravelSwagger\Models\Server;

final class Swagger implements Contract
{
    use Arrayable;

    protected $data = [
        'openapi'    => '3.0.0',
        'components' => [
            'schemas'         => [],
            'securitySchemes' => [],
        ],
        'tags'       => [],
    ];

    protected $paths = [];

    public function toArray()
    {
        return $this->convertToArray(array_merge_recursive($this->data, [
            'info'    => $this->info(),
            'servers' => $this->servers(),
            'paths'   => $this->paths(),
        ]));
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function addPath(Pathable $path): Contract
    {
        array_push($this->paths, $path);

        return $this;
    }

    protected function info(): Info
    {
        return new Info();
    }

    protected function servers(): array
    {
        return collect(ConfigFacade::servers())
            ->mapInto(Server::class)
            ->toArray();
    }

    protected function paths(): array
    {
        return $this->paths;
    }
}
