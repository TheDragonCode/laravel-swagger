<?php

namespace Helldar\LaravelSwagger\Models;

use Helldar\LaravelRoutesCore\Models\Tags\BaseTag;
use Helldar\LaravelSwagger\Contracts\Schemas\Responsible;
use Helldar\LaravelSwagger\Contracts\Schemas\Schema;
use Helldar\LaravelSwagger\Models\Schemas\Make as MakeSchema;
use Helldar\LaravelSwagger\Services\Reference;

final class Response extends BaseModel implements Responsible
{
    public $code;

    /** @var \Helldar\LaravelRoutesCore\Models\Tags\Throws */
    protected $tag;

    /**
     * @param  \Helldar\LaravelRoutesCore\Models\Tags\BaseTag  $tag
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    public function __construct(BaseTag $tag)
    {
        $this->tag = $tag;

        $this->setDescription();
        $this->setContent();
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): Responsible
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     *
     * @return string
     */
    protected function schemaReference(): string
    {
        return Reference::make()->link(
            $this->resolveSchema()
        );
    }

    protected function resolveSchema(): Schema
    {
        return MakeSchema::make()
            ->setDescription($this->getAttribute('description'));
    }

    protected function setDescription(): void
    {
        $value = $this->tag->getDescription() ?: __('Empty description.');

        $this->setAttribute('description', $value);
    }

    /**
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    protected function setContent(): void
    {
        $value = [
            'application/json' => [
                'schema' => [
                    '$ref' => $this->schemaReference(),
                ],
            ],
        ];

        $this->setAttribute('content', $value);
    }
}
