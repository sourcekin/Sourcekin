<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection\Compiler;

use Prooph\ServiceBus\Plugin\Router\EventRouter;
use SourcekinBundle\DependencyInjection\ContainerHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EventHandlersPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('sourcekin.event_handlers');
        $handlers   = $definition->getArguments()[0] ?? [];
        foreach ($container->findTaggedServiceIds('sourcekin.event_handler') as $id => $tags) {
            $handlers[$id] = new Reference($id);
        }

        $definition->setArgument(0, $handlers);

    }
}