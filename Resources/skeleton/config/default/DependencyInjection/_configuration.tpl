<?php

{% include 'header.twig' %}

namespace {{ namespace }}\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('{{ alias }}', 'array')
            ->children()
                ->scalarNode('param1')->defaultValue('value1')->end()
                ->arrayNode('param2')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('key1')->defaultValue('value2-1')->end()
                        ->scalarNode('key2')->defaultValue('value2-2')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
