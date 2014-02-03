<?php

namespace Tms\Bundle\FormGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class FormFieldTypeCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $formFieldTypes = $container->getParameter('tms_form_generator.form_field_types');

        $serviceDefinitionNames = array();

        foreach ($formFieldTypes as $id => $parameters) {
            $serviceDefinition = new DefinitionDecorator('tms_form_generator.form_field.type');
            $serviceDefinitionNames[$id] = sprintf('tms_form_generator.form_field.type.%s', $id);
            $parent = null;
            if ($parameters['parent']) {
                $parent = new Reference($serviceDefinitionNames[$parameters['parent']]);
            }

            $serviceDefinition->isAbstract($parameters['abstract']);
            $serviceDefinition->replaceArgument(0, $parameters['type']);
            $serviceDefinition->replaceArgument(1, $parent);
            $serviceDefinition->replaceArgument(2, $parameters['options']);

            $container->setDefinition($serviceDefinitionNames[$id], $serviceDefinition);
        }
    }
}
