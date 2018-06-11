<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Factory;

use ReflectionClass;

class ReflectionFactory implements FactoryInterface
{
    public function isSupported($class)
    {
        return (interface_exists($class) || class_exists($class));
    }


    /**
     * @param                     $class
     * @param DomainObjectFactory $factory
     * @param array               $context
     *
     * @return object
     * @throws \ReflectionException
     */
    public function make($class, DomainObjectFactory $factory, array $context = [])
    {
        $reflection = $this->getReflectionClass($class);
        foreach (MethodResolver::resolveArguments($reflection,$reflection->getConstructor(),$context) as $i => $argument) {
            $value = $this->findArgumentValue($class, $context, $argument, $i);
            $args[] = $value->given() ? $value->value() : $this->resolveValue($value, $argument, $factory);
        };

        return $reflection->newInstance($args??[]);
    }

    /**
     * @param       $class
     * @param array $context
     * @param       $argument
     * @param       $index
     *
     * @return ArgumentValue
     */
    protected function findArgumentValue($class, array $context, ArgumentMetaData $argument, $index)
    {
        if (array_key_exists($name = $argument->name(), $context)) {
            return new GivenArgumentValue($context[$name]);
        }

        if (array_key_exists($key = $argument->key(), $context)) {
            return new GivenArgumentValue($context[$key]);
        }

        if (array_key_exists($index, $context)) {
            return new GivenArgumentValue($context[$index]);
        }

        if (!$argument->required()) {
            return new DefaultArgumentValue($argument->default());
        }

        throw new \LogicException(
            sprintf('No value available for argument $%s in class constructor "%s::__construct()".', $name, $class)
        );
    }

    protected function resolveValue(ArgumentValue $argument, ArgumentMetaData $metaData, DomainObjectFactory $factory)
    {
        if (is_object($argument->value())) {
            return $argument->value();
        }
        if (interface_exists($metaData->type() || class_exists($metaData->type()))) {
            return $factory->make($metaData->type(), (array)$argument->value());
        }

        return null;
    }

    /**
     * @param $class
     *
     * @return ReflectionClass
     * @throws \ReflectionException
     */
    protected function getReflectionClass($class)
    {
        return new ReflectionClass($class);
    }
}