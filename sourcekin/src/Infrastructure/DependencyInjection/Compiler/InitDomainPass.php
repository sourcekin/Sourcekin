<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Infrastructure\DependencyInjection\Compiler;

use Sourcekin\Infrastructure\DependencyInjection\ConfigurationHelper;
use Sourcekin\Infrastructure\Messenger\ConsoleMessageReceiverBus;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class InitDomainPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        foreach (array_keys($container->findTaggedServiceIds('sourcekin.domain.message_handler')) as $id) {
            $handler = $container->findDefinition($id);
            $message = current(
                ConfigurationHelper::getMethodArgumentTypes(
                    ConfigurationHelper::getClassReflection($container, $id),
                    '__invoke'
                )
            );
            $handler->addTag('messenger.message_handler', ['handles' => $message]);
            $handler->clearTag('sourcekin.domain.message_handler');
        }

        if (class_exists(ConsoleEvents::class)) {
            foreach ($container->findTaggedServiceIds('messenger.bus') as $id => $attr) {
                self::register($container, ConsoleMessageReceiverBus::class, ConsoleMessageReceiverBus::class.'.'.$id)
                    ->setDecoratedService($id)
                    ->setAutowired(true)
                    ->setArgument('$bus', new Reference(ConsoleMessageReceiverBus::class.'.'.$id.'.inner'))
                ;
            }
        }

    }

    private static function register(ContainerBuilder $container, string $class, string $id = null): Definition
    {
        return $container->register($id ?? $class, $class)->setPublic(false);
    }

    private static function alias(ContainerBuilder $container, string $alias, string $id): void
    {
        $container->setAlias($alias, new Alias($id, false));
    }
}