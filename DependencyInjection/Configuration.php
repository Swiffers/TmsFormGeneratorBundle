<?php

namespace Tms\Bundle\FormGeneratorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tms_form_generator');

        $rootNode
            ->children()
                ->arrayNode('constraints')
                    ->defaultValue(array())
                    ->prototype('array')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
                ->scalarNode('service')
                    ->defaultValue('tms_form_generator.generator.default')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
