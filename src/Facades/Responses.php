<?php

namespace Helldar\LaravelSwagger\Facades;

use Helldar\LaravelSwagger\Services\Responses as ResponsesService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array get()
 */
final class Responses extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ResponsesService::class;
    }
}
