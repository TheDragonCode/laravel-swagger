<?php

namespace Helldar\LaravelSwagger\Contracts;

use Illuminate\Routing\RouteCollectionInterface;

interface Route
{
    public function map(RouteCollectionInterface $routes);

    public function middleware(): array;

    public function action(): string;

    public function classname(): string;

    public function uri(): string;

    public function methods(): array;

    public function responses(): array;

    public function summary(): ?string;

    public function description(): ?string;

    public function security(): array;

    public function addResponse(Responsible $response);

    public function addResponses(array $responses);
}
