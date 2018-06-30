<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 30.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection\Compiler;

use SourcekinBundle\DependencyInjection\ContainerHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class QueryHandlersPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('sourcekin.query_handlers');
        $handlers   = [];
        foreach ($container->findTaggedServiceIds('sourcekin.query_handler') as $id => $tags) {
            $classKey = ContainerHelper::getHandledCommand($id, $container);
            $handlers[$classKey] = new Reference($id);
        }

        $definition->setArgument(0, $handlers);

    }
}