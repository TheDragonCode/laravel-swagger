<?php

namespace Helldar\LaravelSwagger\Services\Grabber;

use Helldar\LaravelSwagger\Services\BaseService;
use Illuminate\Http\Resources\Json\JsonResource;

final class Resources extends BaseService
{
    public function handle()
    {
        $files = $this->search(JsonResource::class);
    }
}
