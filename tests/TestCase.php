<?php

namespace Tests;

use Helldar\LaravelSwagger\ServiceProvider;
use Helldar\LaravelSwagger\Services\Config;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->setConfig($app);
        $this->setRoutes($app);
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

    protected function setRoutes($app)
    {
        $app['router']->get('/foo', function () {
        });

        $app['router']->match(['PUT', 'PATCH'], '/bar', function () {
        });

        $app['router']->get('/_ignition/baq', function () {
        });

        $app['router']->get('/telescope/baw', function () {
        });

        $app['router']->get('/_debugbar/bae', function () {
        });
    }
}
