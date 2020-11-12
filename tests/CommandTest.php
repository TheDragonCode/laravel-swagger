<?php

namespace Tests;

use Helldar\LaravelSwagger\Facades\Config;

final class CommandTest extends TestCase
{
    public function testCommand(): void
    {
        $this->artisan('swagger:generate')
            ->assertExitCode(0);

        $this->assertFileExists($this->path('1.0', 'json'));
        $this->assertFileExists($this->path('1.0', 'yaml'));
    }

    public function testCustomVersionCommand(): void
    {
        $this->artisan('swagger:generate', [
            '--ver' => '1.2.3',
        ])->assertExitCode(0);

        $this->assertFileExists($this->path('1.2.3', 'json'));
        $this->assertFileExists($this->path('1.2.3', 'yaml'));
    }

    protected function path(string $version, string $extension): string
    {
        return Config::fullPath(
            $version . '.' . $extension
        );
    }
}
