<?php

/**
 * @author:  Benjamin TARDY <benjamin.tardy@tessi.fr>
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Generators;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tms\Bundle\FormGeneratorBundle\Exceptions\ConstraintNotFoundException;

class FormBuilderGenerator implements GeneratorInterface
{
    protected $formFactory;
    protected $formFieldTypes;

    /**
     * FormGenerator constructor
     *
     * @param FormFactoryInterface $formFactory Instance of FormFactory
     * @param array $formFieldTypes
     */
    public function __construct(FormFactoryInterface $formFactory, array $formFieldTypes)
    {
        $this->formFactory    = $formFactory;
        $this->formFieldTypes = $formFieldTypes;
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
     * getBooleanOptions
     *
     * @return array
     */
    public static function getBooleanOptions()
    {
        return array(
            'required',
            'disabled',
            'trim',
            'read_only',
            'always_empty',
            'expanded',
            'multiple',
            'with_seconds'
        );
    }

    /**
     * setDefaultFieldOptions
     *
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultFieldOptions(OptionsResolverInterface $resolver)
    {
        $booleanOptions = self::getBooleanOptions();
        $formFieldTypes = $this->formFieldTypes;
        $resolver
            ->setRequired(array('name', 'type'))
            ->setAllowedValues(array('type' => array_keys($this->formFieldTypes)))
            ->setDefaults(array(
                'options'     => array(),
                'constraints' => array(),
                'eligibility' => array(),
                'indexed'     => false
            ))
            ->setNormalizers(array(
                'type' => function (Options $options, $value) use ($formFieldTypes) {
                    if (isset($formFieldTypes[$value])) {
                        return $formFieldTypes[$value]['type'];
                    }

                    return $value;
                },
                'options' => function (Options $options, $values) use ($booleanOptions) {
                    if (!$values) {
                        return array();
                    }

                    foreach ($values as $k => $v) {
                        if (in_array($k, $booleanOptions)) {
                            $values[$k] = (boolean)$v;
                        } elseif (empty($v)) {
                            unset($values[$k]);
                        }
                    }

                    return $values;
                },
                'constraints' => function (Options $options, $values) {
                    if (!$values) {
                        return array();
                    }

                    return $values;
                },
                'eligibility' => function (Options $options, $values) {
                    if (!$values) {
                        return array();
                    }

                    return $values;
                },
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(array $options = array())
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

        // TODO: Uncoment this part and work on constraints !
        //$parameters['options']['constraints'] = $parameters['constraints'];
        $parameters['options']['constraints'] = null;
        $formBuilder->add($parameters['name'], $parameters['type'], $parameters['options']);
    }
}
