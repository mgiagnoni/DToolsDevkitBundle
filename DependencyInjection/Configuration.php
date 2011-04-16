<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This class contains the configuration information for the bundle
 *
 */
class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('d_tools_devkit', 'array')
            ->children()
                ->arrayNode('author')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('name')->defaultNull()->end()
                        ->scalarNode('email')->defaultNull()->end()
                    ->end()
               ->end()
               ->arrayNode('generator')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->cannotBeEmpty()->defaultValue('DTools\DevkitBundle\Generator\DefaultGenerator')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder->buildTree();
    }
}