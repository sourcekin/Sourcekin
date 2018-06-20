<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProjectorsPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $projectorLocator = $container->findDefinition('sourcekin.projection.projectors');
        $readModelLocator = $container->findDefinition('sourcekin.projection.read_models');
        $projectors       = $readModels = [];

        foreach ($container->findTaggedServiceIds('sourcekin.projector') as $id => $tags) {
            $tag               = current($tags);
            $name              = $tag['projection'];
            $projectors[$name] = new Reference($id);

            if( isset($tag['read_model'])) {
                $readModels[$name] = new Reference($tag['read_model']);
            }
        }

        $projectorLocator->setArgument(0, $projectors);
        $readModelLocator->setArgument(0, $readModels);

    }
}