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

class StepHandlerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('tms_form_generator.step.container');
        $steps = array();

        $stepHandlersConfiguration = $container->getParameter('tms_form_generator.step_handlers');
        foreach ($stepHandlersConfiguration as $stepHandlerId => $stepHandlerConfiguration) {
            $stepHandlerServiceId = sprintf(
                'tms_form_generator.step.handler.%s',
                $stepHandlerId
            );

            $stepHandlerDefinition = new DefinitionDecorator('tms_form_generator.step.handler');
            $stepHandlerDefinition->setAbstract(false);
            $stepHandlerDefinition->replaceArgument(1, $stepHandlerId);
            $stepHandlerDefinition->replaceArgument(2, $stepHandlerConfiguration);

            $container->setDefinition($stepHandlerServiceId, $stepHandlerDefinition);

            $definition->addMethodCall(
                'setStepHandler',
                array($stepHandlerId, new Reference($stepHandlerServiceId))
            );

            $steps[$stepHandlerId] = $stepHandlerConfiguration['name'];
        }

        $container->setParameter('tms_form_generator.configuration.steps', $steps);
    }
}
