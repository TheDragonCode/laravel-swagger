<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Concerns\Arrayable;
use Helldar\LaravelSwagger\Contracts\Pathable;
use Helldar\LaravelSwagger\Contracts\Swagger as Contract;
use Helldar\LaravelSwagger\Facades\Config as ConfigFacade;
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

    protected $version;

    public function toArray()
    {
        return $this->convertToArray(array_merge_recursive($this->data, [
            'info'    => [
                'title'   => $this->title(),
                'version' => $this->version,
            ],
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

    public function setVersion(string $version): Contract
    {
        $this->version = $version;

        return $this;
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

    protected function title(): string
    {
        return ConfigFacade::title();
    }
}
