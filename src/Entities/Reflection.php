<?php

namespace Helldar\LaravelSwagger\Entities;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;
use ReflectionMethod;

final class Reflection extends BaseEntity
{
    /** @var \phpDocumentor\Reflection\DocBlockFactory */
    protected static $factory;

    /** @var \ReflectionClass|\ReflectionMethod */
    protected $reflection;

    /**
     * @param  string  $class
     * @param  string|null  $method
     *
     * @throws \ReflectionException
     */
    public function __construct(string $class, string $method = null)
    {
        $this->reflection = ! empty($method)
            ? $this->makeMethod($class, $method)
            : $this->makeClass($class);
    }

    public function summary(): ?string
    {
        return optional($this->getDocBlock())->getSummary();
    }

    public function description(): ?string
    {
        return optional($this->getDocBlock())->getDescription();
    }

    public function getReflection()
    {
        return $this->reflection;
    }

    public function getDocBlock(): ?DocBlock
    {
        if ($comment = $this->reflection->getDocComment()) {
            return $this->factory()->create($comment);
        }

        return null;
    }

    /**
     * @param  string  $class
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionClass
     */
    protected function makeClass(string $class): ReflectionClass
    {
        return new ReflectionClass($class);
    }

    /**
     * @param  string  $class
     * @param  string  $method
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionMethod
     */
    protected function makeMethod(string $class, string $method): ReflectionMethod
    {
        return new ReflectionMethod($class, $method);
    }

    protected function factory(): DocBlockFactory
    {
        if (! static::$factory) {
            static::$factory = DocBlockFactory::createInstance();
        }

        return static::$factory;
    }
}
