<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Factory;

interface FactoryInterface
{
    /**
     * @param $class
     *
     * @return bool
     */
    public function isSupported($class);

    /**
     * @param                     $class
     * @param DomainObjectFactory $factory
     * @param array               $context
     *
     * @return object
     */
    public function make($class, DomainObjectFactory $factory, array $context = []);
}