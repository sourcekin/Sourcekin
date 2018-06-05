<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace Sourcekin\Integration\DependencyInjection\Compiler;

use InvalidArgumentException;
use Sourcekin\Domain\Message\BusInterface;
use Sourcekin\Integration\Messenger\Bus;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Messenger\MessageBusInterface;

class InitializeDomainPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if( $container->has(BusInterface::class)) return;
        if(! $container->has(MessageBusInterface::class)) return;

        $this->register($container, $alias = Bus::class)->setAutowired(true)->setPublic(false);
        $this->alias($container, BusInterface::class, $alias);
        foreach($container->findTaggedServiceIds('sourcekin.domain.command_handler') as $id => $tags) {
            $definition = $container->findDefinition($id);
            $command = self::getClassReflection($container, $definition->getClass() ?? $id)->getMethod('__invoke')->getParameters()[0]->getClass()->getName();
            $definition->addTag('messenger.message_handler', ['handles' => $command]);
        }

    }

    public static function getClassReflection(ContainerBuilder $container, ?string $class): \ReflectionClass
    {
        if (!$class || !($reflection = $container->getReflectionClass($class))) {
            throw new InvalidArgumentException(sprintf('Invalid class "%s".', $class));
        }

        return $reflection;
    }

    protected function register(ContainerBuilder $container, string $class, string $id = null): Definition
    {
        return $container->register($id ?? $class, $class)->setPublic(false);
    }

    private function alias(ContainerBuilder $container, string $alias, string $id): void
    {
        $container->setAlias($alias, new Alias($id, false));
    }

}