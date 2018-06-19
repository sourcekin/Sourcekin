<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder() {
        $rootNode = ($treeBuilder = new TreeBuilder())->root('sourcekin');

        $rootNode
            ->children()
                ->arrayNode('modules')
                ->scalarPrototype()
            ->end()
        ;

        return $treeBuilder;

    }
}