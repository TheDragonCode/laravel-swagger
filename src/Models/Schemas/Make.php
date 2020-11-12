<?php

namespace Helldar\LaravelSwagger\Models\Schemas;

use Helldar\LaravelSwagger\Contracts\Schemas\Schema;
use Helldar\LaravelSwagger\Models\Response;
use Helldar\LaravelSwagger\Support\Schemas;
use Illuminate\Database\Eloquent\Model;

final class Make extends BaseSchema
{
    protected $attributes = [
        'type' => 'object',
    ];

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownPropertyNameException
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     *
     * @return \Helldar\LaravelSwagger\Models\Schemas\Make
     */
    public function fromModel(Model $model): self
    {
        $this->setDescription(get_class($model));
        $this->setProperties($model);

        return $this;
    }

    public function fromResponse(Response $response): self
    {
        $this->setDescription(get_class($response));

        return $this;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownPropertyNameException
     * @throws \Helldar\LaravelSwagger\Exceptions\UnknownSchemaException
     */
    protected function setProperties(Model $model)
    {
        $schema = $this->getSchema();

        foreach ($model->getAttributes() as $key => $value) {
            $this->addProperty(
                $schema->getProperty($key)
            );
        }
    }

    protected function getSchema(): Schema
    {
        return Schemas::get(Basic::class);
    }
}
