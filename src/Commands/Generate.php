<?php

namespace Helldar\LaravelSwagger\Commands;

use Helldar\LaravelSwagger\Factories\Generator;
use Illuminate\Console\Command;

final class Generate extends Command
{
    protected $signature = 'swagger:generate';

    protected $description = 'Generating documentation for Swagger';

    protected $exceptions;

    public function handle(Generator $factory)
    {
        $this->info('Regenerating docs...');

        $factory->make()->generate();

        $this->info('Documentation generated successfully.');
    }
}
