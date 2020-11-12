<?php

namespace Helldar\LaravelSwagger\Models\Properties\Concerns;

use Faker\Factory;

/**
 * @mixin \Helldar\LaravelSwagger\Models\Properties\BaseProperty
 * @mixin \Helldar\LaravelSwagger\Models\BaseModel
 */
trait Faker
{
    /** @var \Faker\Generator */
    protected $faker;

    protected function makeExample()
    {
        $this->setExample($this->castFakeType());
    }

    protected function getFaker()
    {
        if (is_null($this->faker)) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }

    protected function castFakeType()
    {
        switch ($this->getAttribute('type')) {
            case 'integer':
            case 'double':
                return $this->castFakeNumericFormat();

            default:
                return $this->getFaker()->text(100);
        }
    }

    protected function castFakeNumericFormat()
    {
        if (property_exists($this, 'format')) {
            switch ($this->format) {
                case 'double':
                    return $this->getFaker()->randomFloat();

                default:
                    return $this->getFaker()->numberBetween();
            }
        }

        return $this->getFaker()->numberBetween();
    }
}
