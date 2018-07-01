<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 01.07.18
 *
 */

namespace SourcekinBundle\DependencyInjection\Compiler;

use Sourcekin\Components\DependencyInjection\Dependencies;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DependenciesPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $dependencies = $container->findDefinition(Dependencies::class);
        $factories    = $dependencies->getArguments()[0]??[];
        foreach($container->findTaggedServiceIds('sourcekin.dependency') as $id => $tags) {
            $alias = current($tags)['alias'];
            $factories[$alias] = new Reference($id);
            if( $alias !== $id) $container->setAlias($alias, $id);
        }

        $plugins = [];
        foreach ($container->findTaggedServiceIds('sourcekin.plugin') as $id => $tags) {
            $type = current($tags)['type'];
            isset($plugins[$type]) or $plugins[$type] = [];
            $plugins[$type][] = $id;
            $factories[$id]   = new Reference($id);
        }

        $dependencies->setArgument(0, $factories);
        $dependencies->addMethodCall('setPlugins', [$plugins]);
    }
}