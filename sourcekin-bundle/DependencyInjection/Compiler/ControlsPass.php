<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 08.07.18.
 */

namespace SourcekinBundle\DependencyInjection\Compiler;


use Sourcekin\Components\Rendering\ControlCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ControlsPass implements CompilerPassInterface {

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @inheritdoc
     */
    public function process(ContainerBuilder $container) {
        $definition = $container->findDefinition(\SourcekinBundle\Rendering\ControlCollection::class);
        $handlers   = $definition->getArguments()[0] ?? [];
        foreach ($container->findTaggedServiceIds('sourcekin.control') as $id => $tags) {
            $name = current($tags)['alias'];
            $handlers[$name] = new Reference($id);
        }

        $definition->setArgument(0, $handlers);
    }
}