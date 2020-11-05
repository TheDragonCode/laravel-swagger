<?php

namespace Tests;

use Helldar\LaravelSwagger\Facades\Files;
use Helldar\LaravelSwagger\Services\Swagger;

final class FilesTest extends TestCase
{
    public function testStoreJson()
    {
        $swagger = new Swagger();
        $path    = storage_path('app/private/api.1.0.json');

        Files::swagger($swagger)->storeJson();

        $this->assertFileExists($path);

        $this->assertJsonStringEqualsJsonFile($path, '[]');
    }

    public function testStoreYaml()
    {
        $swagger = new Swagger();
        $path    = storage_path('app/private/api.1.0.yaml');

        Files::swagger($swagger)->storeYaml();

        $this->assertFileExists($path);

        $this->assertJsonStringEqualsJsonFile($path, '[]');
    }
}
