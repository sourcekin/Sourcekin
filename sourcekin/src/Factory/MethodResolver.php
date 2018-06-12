<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Factory;

use ReflectionClass;
use ReflectionMethod;

class MethodResolver
{
    protected static $cache;

    /**
     * @param \ReflectionParameter $param
     * @param                      $type
     *
     * @return array
     */
    protected static function evaluateParameterAttributes(\ReflectionParameter $param, $type): array
    {
        $required = false;
        if ($param->isDefaultValueAvailable()) {
            $default = $param->getDefaultValue();
        } elseif ($param->allowsNull()) {
            $default = null;
        } elseif ('array' === $type || 'iterable' === $type) {
            $default  = [];
            $required = true;
        } else {
            $default  = null;
            $required = true;
        }

        return array($required, $default, $type);
    }
    /**
     * @param \ReflectionParameter $param
     * @param                      $type
     *
     * @return string
     */
    protected static function evaluateType(\ReflectionParameter $param, $type): string
    {
        if (null !== $type) {
            if ('self' === strtolower($name = $type->getName())) {
                $type = $param->getClass()->getName();
            } elseif ($type->isBuiltin()) {
                $type = $name;
            } else {
                try {
                    $type = (new \ReflectionClass($name))->getName();
                } catch (\ReflectionException $e) {
                    $type = $name;
                }
            }
        }

        return $type;
    }

    protected static function  doResolve(ReflectionMethod $method) {
        return array_map(function (\ReflectionParameter $param): ArgumentMetaData {
            list($required, $default, $type) = static::evaluateParameterAttributes($param,
                static::evaluateType($param, $param->getType())
            );

            return new ArgumentMetaData($param->getName(), $required, $default, $type);

        }, $method->getParameters());
    }

    /**
     * @param ReflectionClass  $class
     * @param ReflectionMethod $method
     * @param array            $context
     *
     * @return ArgumentMetaData[]
     */
    public static function resolveArguments(ReflectionClass $class,  ReflectionMethod $method, array $context = [])
    {
        $key = sprintf('%s::%s', $class->getName(), $method->getName());
        if( ! isset(static::$cache[$key])) {
            static::$cache[$key] = static::doResolve($method);
        }

        return static::$cache[$key];

    }
}