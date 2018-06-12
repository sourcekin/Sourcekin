<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Factory;

use Sourcekin\Exception\UnsupportedClass;

class DomainObjectFactory
{
    /**
     * @var FactoryInterface[]
     */
    protected $factories = [];

    /**
     * @var array
     */
    protected $classMap = [];


    /**
     * DomainObjectFactory constructor.
     *
     * @param FactoryInterface[] $factories
     * @param array              $classMap
     */
    public function __construct(array $factories, array $classMap = [])
    {
        $this->factories = $factories;
        $this->classMap  = $classMap;
    }

    /**
     * @param       $name
     * @param array $context
     *
     * @return object
     */
    public function make($name, array $context = [])
    {
        $target = $this->targetClass($name);
        foreach ($this->factories as $factory) {
            if ($factory->isSupported($target)) {
                return $factory->make($target, $this, $context);
            }
        }
        throw new UnsupportedClass($name);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    protected function targetClass($name)
    {
        return $this->classMap[$name] ?? $name;
}
}