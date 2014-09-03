<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Step\ConfigurationForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractStepConfigurationFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('position', 'integer')
        ;

        if($this->hasGenerationParameters()) {
            $builder->add(
                'generationParameters',
                $this->getGenerationParametersType(),
                $this->getGenerationParameters()
            );
        }

        if($this->hasContentParameters()) {
            $builder->add(
                'contentParameters',
                $this->getContentParametersType(),
                $this->getContentParameters()
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tms\Bundle\FormGeneratorBundle\Step\StepInterface'
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
     * @return array()
     */
    public function getGenerationParameters()
    {
        return array();
    }

    /**
     * getContentParameters
     *
     * @return array()
     */
    public function getContentParameters()
    {
        return array();
    }
}
