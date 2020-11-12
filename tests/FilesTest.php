<?php

namespace Tests;

use Helldar\LaravelSwagger\Facades\Files;
use Helldar\LaravelSwagger\Services\Swagger;

final class FilesTest extends TestCase
{
    public function testStoreJson()
    {
        $path = storage_path('app/private/api.1.0.json');

        $swagger = new Swagger();
        $swagger->setVersion('1.0');

        Files::swagger($swagger)->storeJson();

        $this->assertFileExists($path);

        $this->assertJsonStringEqualsJsonFile($path, '[]');
    }

    public function testStoreYaml()
    {
        $path = storage_path('app/private/api.1.0.yaml');

        $swagger = new Swagger();
        $swagger->setVersion('1.0');

        Files::swagger($swagger)->storeYaml();

        $this->assertFileExists($path);

        $this->assertJsonStringEqualsJsonFile($path, '[]');
    }
}
