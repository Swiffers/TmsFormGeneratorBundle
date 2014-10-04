<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Step\ConfigurationForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractStepConfigurationFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
        ;

        if (!$options['display_simplified_form']) {
            $builder->add('description', 'textarea', array('required' => false));

            if($this->hasGenerationParameters()) {
                $builder->add(
                    'generationParameters',
                    $this->getGenerationParametersType(),
                    $this->getGenerationParameters($options['generation_options'])
                );
            }

            if($this->hasContentParameters()) {
                $builder->add(
                    'contentParameters',
                    $this->getContentParametersType(),
                    $this->getContentParameters($options['content_options'])
                );
            }
        } else {
            $builder->add('handlerServiceId', 'step_choice');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'display_simplified_form' => false,
            'data_class'              => 'Tms\Bundle\FormGeneratorBundle\Step\Step',
            'generation_options'      => array(),
            'content_options'         => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tms_form_generator_step_type';
    }

    /**
     * hasGenerationParameters
     *
     * @return boolean
     */
    public function hasGenerationParameters()
    {
        return true;
    }

    /**
     * hasContentParameters
     *
     * @return boolean
     */
    public function hasContentParameters()
    {
        return true;
    }

    /**
     * getGenerationParametersType
     *
     * @return string
     */
    public function getGenerationParametersType()
    {
        return "textarea";
    }

    /**
     * getContentParametersType
     *
     * @return string
     */
    public function getContentParametersType()
    {
        return "textarea";
    }

    /**
     * getGenerationParameters
     *
     * @param  array $options
     * @return array()
     */
    public function getGenerationParameters(array $options = array())
    {
        return array();
    }

    /**
     * getContentParameters
     *
     * @param  array $options
     * @return array()
     */
    public function getContentParameters(array $options = array())
    {
        return array();
    }
}
