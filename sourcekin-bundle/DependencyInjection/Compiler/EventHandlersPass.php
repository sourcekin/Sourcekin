<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection\Compiler;

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
        $router   = $container->findDefinition('sourcekin.event_router');
        $eventMap = $router->getArguments()[0]?? [];
        foreach ($container->findTaggedServiceIds('sourcekin.event_handler') as $id => $tags) {
            $container->findDefinition($id)->setLazy(true);
            $event = ContainerHelper::getHandledCommand($id, $container);
            isset($eventMap[$event]) or $eventMap[$event] = [];
            $eventMap[$event][] = new Reference($id);
        }
        $router->setArgument(0, $eventMap);
    }
}