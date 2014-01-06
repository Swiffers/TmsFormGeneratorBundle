<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tms\Bundle\FormGeneratorBundle\Form\DataTransformer\FormFieldTransformer;

class FormFieldType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new FormFieldTransformer();
        $builder->addModelTransformer($transformer);

        if ($options['name_field']) {
            $builder->add(
                'name',
                $options['name_field']['type'],
                $options['name_field']['options']
            );
        }

        if ($options['add_indexed_field']) {
            $builder->add('indexed', 'switch_checkbox');
        }

        $builder
            ->add('type', 'form_field_type_choice')
            ->add('options', 'form_field_options')
            ->add('constraints', 'form_field_constraints')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'tms_form_generator_form_field'
            ),
            'name_field' => array(
                'type' => 'text',
                'options' => array()
            ),
            'add_indexed_field' => false
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
