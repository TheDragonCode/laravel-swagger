<?php

namespace Helldar\LaravelSwagger\Entities\Schemas;

final class SecuritySchema extends BaseSchema
{
    public function type(): string
    {
        return 'securitySchemes';
    }
}
