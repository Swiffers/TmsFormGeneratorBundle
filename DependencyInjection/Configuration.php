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
                ->append($this->addFormFieldTypesNode())
                ->arrayNode('form_field_constraints')
                    ->defaultValue(array())
                    ->prototype('array')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    protected function addFormFieldTypesNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('form_field_types');

        $node
            ->defaultValue(array())
            ->useAttributeAsKey('id')
            ->prototype('array')
                ->children()
                    ->scalarNode('type')->isRequired()->end()
                    ->booleanNode('abstract')->defaultFalse()->end()
                    ->scalarNode('parent')->defaultNull()->end()
                    ->arrayNode('options')
                        ->defaultValue(array())
                        ->prototype('array')
                            ->children()
                                ->scalarNode('type')->end()
                                ->arrayNode('options')
                                    ->prototype('variable')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->scalarNode('alias')->defaultNull()->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
