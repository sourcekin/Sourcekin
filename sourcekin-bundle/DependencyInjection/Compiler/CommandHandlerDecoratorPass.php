<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace SourcekinBundle\DependencyInjection\Compiler;


use SourcekinBundle\Broadway\CommandHandlerDecorator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CommandHandlerDecoratorPass implements CompilerPassInterface {

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container) {

        foreach ($container->findTaggedServiceIds('sourcekin.command_handler') as $id => $tags) {
            $key = sprintf('%s.broadway_adapter', $id);
            $container
                ->register($key, CommandHandlerDecorator::class)
                ->setDecoratedService($id)
                ->addArgument(new Reference($key . '.inner'))
                ->addTag('broadway.command_handler');
        }
    }
}