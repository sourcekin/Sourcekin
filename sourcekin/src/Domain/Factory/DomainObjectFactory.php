<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Factory;

use Sourcekin\Domain\Exception\UnsupportedClass;

class DomainObjectFactory
{
    /**
     * @var FactoryInterface[]
     */
    protected $factories = [];

    /**
     * @param       $name
     * @param array $context
     * @return object
     */
    public function make($name, array $context = []) {
        foreach ($this->factories as $factory) {
            if( $factory->isSupported($name)) return $factory->make($name, $this, $context);
        }
        throw new UnsupportedClass($name);
    }
}