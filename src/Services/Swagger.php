<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Concerns\EnumeratesValues;
use Helldar\LaravelSwagger\Contracts\Pathable;
use Helldar\LaravelSwagger\Contracts\Swagger as Contract;
use Helldar\LaravelSwagger\Facades\Config as ConfigFacade;
use Helldar\LaravelSwagger\Models\Server;
use Helldar\LaravelSwagger\Support\Schemas;

final class Swagger implements Contract
{
    use EnumeratesValues;

    protected $data = [
        'openapi' => '3.0.0',
        'tags'    => [],
    ];

    protected $paths = [];

    protected $version;

    public function addPath(Pathable $path): Contract
    {
        array_push($this->paths, $path);

        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): Contract
    {
        $this->version = $version;

        return $this;
    }

    public function toArray()
    {
        $info       = $this->getInfo();
        $servers    = $this->getServers();
        $paths      = $this->getPaths();
        $components = $this->getComponents();

        return $this->arrayable(
            array_merge($this->data, compact('info', 'servers', 'paths', 'components'))
        );
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    protected function getServers(): array
    {
        return collect(ConfigFacade::servers())
            ->mapInto(Server::class)
            ->toArray();
    }

    protected function getPaths(): array
    {
        return $this->paths;
    }

    protected function title(): string
    {
        return ConfigFacade::title();
    }

    protected function schemes(): array
    {
        return Schemas::all();
    }

    protected function securitySchemes(): array
    {
        return ConfigFacade::securitySchemes();
    }

    protected function getInfo(): array
    {
        return [
            'title'   => $this->title(),
            'version' => $this->version,
        ];
    }

    protected function getComponents(): array
    {
        return [
            'schemas'         => $this->schemes(),
            'securitySchemes' => $this->securitySchemes(),
        ];
    }
}
