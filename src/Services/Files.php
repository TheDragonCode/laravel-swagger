<?php

namespace Helldar\LaravelSwagger\Services;

use Helldar\LaravelSwagger\Contracts\Swagger as Contract;
use Helldar\LaravelSwagger\Facades\Config as ConfigFacade;
use Helldar\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

final class Files
{
    /** @var \Helldar\LaravelSwagger\Contracts\Swagger */
    protected $swagger;

    public function swagger(Contract $swagger)
    {
        $this->swagger = $swagger;

        return $this;
    }

    public function storeAll(): void
    {
        $this->storeJson();
        $this->storeYaml();
    }

    public function storeJson(): void
    {
        $content = $this->swagger->toJson(JSON_PRETTY_PRINT ^ JSON_OBJECT_AS_ARRAY ^ JSON_UNESCAPED_UNICODE);

        $this->store($content, 'json');
    }

    public function storeYaml(): void
    {
        $doc = Yaml::dump(
            $this->swagger->toArray(),
            20, 4,
            Yaml::DUMP_OBJECT_AS_MAP ^ Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE
        );

        $this->store($doc, 'yaml');
    }

    protected function store($content, string $extension): void
    {
        File::store($this->path($extension), $content);
    }

    protected function path(string $extension): string
    {
        return ConfigFacade::path(ConfigFacade::filename(
            $this->version() . '.' . $extension
        ));
    }

    protected function version(): string
    {
        return ConfigFacade::version();
    }
}
