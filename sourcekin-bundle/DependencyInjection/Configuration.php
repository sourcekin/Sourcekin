<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use App\Entity\User;
use Sourcekin\Domain\Entity\User as SourcekinUser;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const DEFAULT_CLASS_MAPPING = [
        SourcekinUser::class => User::class,
    ];
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $children = ($treeBuilder = new TreeBuilder())->root(Extension::ALIAS)->children();
        $children->scalarNode('bus')->defaultValue('simplebus')->end();
        $children->arrayNode('class_mapping')->prototype('scalar')->defaultValue(static::DEFAULT_CLASS_MAPPING)->end();

        return $treeBuilder;
    }
}