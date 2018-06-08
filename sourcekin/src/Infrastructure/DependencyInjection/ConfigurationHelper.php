<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Infrastructure\DependencyInjection;

use Sourcekin\Infrastructure\Messenger\FallbackMessageHandler;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ConfigurationHelper
{
    private static $counter = 0;

    public static function getPackagePath($relative)
    {
        return dirname(dirname(__DIR__)).$relative;
    }

    public static function getClassReflection(ContainerBuilder $container, $id)
    {
        $definition = $container->findDefinition($id);

        return $container->getReflectionClass($definition->getClass() ?? $id);
    }

    public static function getMethodArgumentTypes(\ReflectionClass $class, $method)
    {
        $params = [];
        foreach ($class->getMethod($method)->getParameters() as $parameter) {
            $params[] = $parameter->getClass()->getName();
        }

        return $params;
    }

    public static function configureEventMessages(
        ContainerBuilder $container,
        array $classMapping = [],
        array $events = []
    ) {
        $messengerHandler = self::registerAnonymous($container, FallbackMessageHandler::class);
        foreach ($events as $event) {
            $mappedEvent = $classMapping[$event] ?? null;

            if (null !== $messengerHandler) {
                $messengerHandler->addTag('messenger.message_handler', ['handles' => $event]);
                if (null !== $mappedEvent) {
                    $messengerHandler->addTag('messenger.message_handler', ['handles' => $mappedEvent]);
                }
            }
        }
    }

    public static function registerAnonymous(
        ContainerBuilder $container,
        string $class,
        bool $child = false
    ): Definition {
        $definition = $child ? new ChildDefinition($class) : new Definition($class);
        $definition->setPublic(false);

        return $container->setDefinition($class.'.'.ContainerBuilder::hash(__METHOD__.++self::$counter), $definition);
    }

    public static function register(ContainerBuilder $container, string $class, string $id = null): Definition
    {
        return $container->register($id ?? $class, $class)->setPublic(false);
    }
}