<?php

/**
 * @author:  Benjamin TARDY <benjamin.tardy@tessi.fr>
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Generators;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tms\Bundle\FormGeneratorBundle\Form\Field\FormFieldConstraintContainer;

class FormBuilderGenerator implements GeneratorInterface
{
    protected $formFactory;
    protected $formFieldConstraintContainer;
    protected $formFieldTypes;

    /**
     * FormGenerator constructor
     *
     * @param FormFactoryInterface $formFactory Instance of FormFactory
     * @param FormFieldConstraintContainer $formFieldContraintContainer
     * @param array $formFieldTypes
     */
    public function __construct(FormFactoryInterface $formFactory, FormFieldConstraintContainer $formFieldConstraintContainer, array $formFieldTypes)
    {
        $this->formFactory                  = $formFactory;
        $this->formFieldConstraintContainer = $formFieldConstraintContainer;
        $this->formFieldTypes               = $formFieldTypes;
    }

    /**
     * setDefaultFormOptions
     *
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultFormOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'fields'  => array(),
            'name'    => null,
            'options' => array('csrf_protection' => false)
        ));
    }

    /**
     * setDefaultFieldOptions
     *O
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultFieldOptions(OptionsResolverInterface $resolver)
    {
        $formFieldTypes = $this->formFieldTypes;
        $resolver
            ->setRequired(array('name', 'type'))
            ->setAllowedValues(array('type' => array_keys($this->formFieldTypes)))
            ->setDefaults(array(
                'options'     => array(),
                'constraints' => array(),
                'indexed'     => false
            ))
            ->setNormalizers(array(
                'type' => function (Options $options, $value) use ($formFieldTypes) {
                    if (isset($formFieldTypes[$value])) {
                        return $formFieldTypes[$value]['type'];
                    }

                    return $value;
                },
                'options' => function (Options $options, $values) {
                    if (!$values || !is_array($values)) {
                        return array();
                    }
                    // Cleanup values
                    foreach ($values as $k => $v) {
                        if (is_string($v) && strlen($v) == 0) {
                            unset($values[$k]);
                        }
                    }

                    return $values;
                },
                'constraints' => function (Options $options, $values) {
                    if (!$values || !is_array($values)) {
                        return array();
                    }
                    // Cleanup values
                    foreach ($values as $k => $v) {
                        if (is_string($v) && strlen($v) == 0) {
                            unset($values[$k]);
                        }
                    }

                    return $values;
                }
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(array $options = array(), $data = array())
    {
        $resolver = new OptionsResolver();
        $this->setDefaultFormOptions($resolver);
        $parameters = $resolver->resolve($options);

        $formBuilder = $this->formFactory->createBuilder(
            'form',
            null,
            $parameters['options']
        );

        if ($parameters['name']) {
            $formBuilder = $this->formFactory->createNamedBuilder(
                $parameters['name'],
                'form',
                null,
                $parameters['options']
            );
        }

        foreach ($parameters['fields'] as $field) {
            if (isset($data[$field['name']])) {
                $field['options']['data'] = $data[$field['name']];
            }
            $this->generateField($formBuilder, $field);
        }

        return $formBuilder;
    }

    /**
     * {@inheritDoc}
     */
    protected function generateField(FormBuilderInterface & $formBuilder, array $options = array())
    {
        $resolver = new OptionsResolver();
        $this->setDefaultFieldOptions($resolver);
        $parameters = $resolver->resolve($options);

        $parameters['options']['constraints'] = $this->generateFieldConstraints($parameters['constraints']);
        $formBuilder->add($parameters['name'], $parameters['type'], $parameters['options']);
    }

    /**
     * {@inheritDoc}
     */
    protected function generateFieldConstraints(array $constraints = array())
    {
        $formConstraints = array();
        foreach ($constraints as $constraint) {
            $formFieldConstraint = $this->formFieldConstraintContainer->getConstraint($constraint['name']);
            $formConstraints[] = $formFieldConstraint->createFormConstraint($constraint['options']);
        }

        return $formConstraints;
    }
}
