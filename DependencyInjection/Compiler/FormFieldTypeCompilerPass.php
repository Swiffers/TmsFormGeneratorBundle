<?php

namespace Tms\Bundle\FormGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class FormFieldTypeCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $formFieldTypes = array();
        $taggedServices = $container->findTaggedServiceIds('form.type');
        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $formFieldTypes[$attributes["alias"]] = $attributes["alias"];
            }
        }

        $container->setParameter(
            'tms_form_generator.form_field_types',
            $formFieldTypes
        );
    }
}
