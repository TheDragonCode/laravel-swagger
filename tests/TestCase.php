<?php

namespace Tests;

use Helldar\LaravelSwagger\ServiceProvider as PackageServiceProvider;
use Helldar\LaravelSwagger\Services\Config;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\fixtures\ServiceProvider as FixtureServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            PackageServiceProvider::class,
            FixtureServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->setConfig($app);
    }

    protected function setConfig($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set(Config::NAME . '.servers', [
            [
                'url'         => 'http://localhost',
                'description' => 'Test Case',
            ],
        ]);
    }
}
