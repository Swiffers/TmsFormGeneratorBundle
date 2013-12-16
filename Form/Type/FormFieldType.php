<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormFieldType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('type', 'form_field_type_choice')
            ->add('indexed', 'switch_checkbox')
            ->add('options', 'form_field_options', array(
                'attr' => array(
                    'class' => 'tms_form_generator_form_field_data totab'
                )
            ))
            ->add('constraints', 'form_field_constraints', array(
                'attr' => array(
                    'class' => 'totab'
                )
            ))
            ->add('eligibility', 'form_field_eligibility', array(
                'attr' => array(
                    'class' => 'totab'
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array(
                'class' => sprintf('tms_form_generator__%s', $this->getName())
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'form_field';
    }
}
