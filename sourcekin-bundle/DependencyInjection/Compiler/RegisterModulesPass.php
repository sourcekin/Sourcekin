<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 19.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterModulesPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $streamNames = [];
        $modules     = [];
        foreach(array_keys($container->findTaggedServiceIds('sourcekin.module')) as $id) {
            $class = $container->findDefinition($id)->getClass()??$id;
            $streamNames[] = $class::streamName();
            $modules[]     = $class;
        }
        $container->setParameter('sourcekin.stream_names', array_filter($streamNames));
        $container->setParameter('sourcekin.modules', $modules);
    }
}