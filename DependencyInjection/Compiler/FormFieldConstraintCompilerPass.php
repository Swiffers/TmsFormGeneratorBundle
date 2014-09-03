<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace Tms\Bundle\FormGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class FormFieldConstraintCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $formFieldConstraints = $container->getParameter('tms_form_generator.form_field_constraints');
        $serviceDefinitionNames = array();
        $containerDefinition = $container->getDefinition('tms_form_generator.form_field.container.constraint');

        foreach ($formFieldConstraints as $id => $parameters) {
            $serviceDefinition = new DefinitionDecorator('tms_form_generator.form_field.constraint');
            $serviceDefinitionNames[$id] = sprintf('tms_form_generator.form_field.constraint.%s', $id);

            $serviceDefinition->isAbstract(false);
            $serviceDefinition->replaceArgument(0, $parameters['class']);
            $serviceDefinition->replaceArgument(1, $parameters['options']);

            $container->setDefinition($serviceDefinitionNames[$id], $serviceDefinition);
            $containerDefinition->addMethodCall(
                'addConstraint',
                array(new Reference($serviceDefinitionNames[$id]), $id)
            );
        }
    }
}
