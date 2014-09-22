<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
use Tms\Bundle\FormGeneratorBundle\Form\DataTransformer\FormFieldTransformer;
use Symfony\Component\Validator\Constraints\NotBlank;

class FormFieldType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$transformer = new FormFieldTransformer();
        //$builder->addModelTransformer($transformer);

        if ($options['name_field']) {
            $builder->add(
                'name',
                $options['name_field']['type'],
                $options['name_field']['options']
            );
        }

        $indexedFieldType = $options['add_indexed_field'] ? 'toggle_button': 'hidden';

        $builder
            ->add('indexed', $indexedFieldType, array(
                'attr' => array('class' => 'form_field_indexed'),
            ))
            ->add('type', 'form_field_type_choice')
            ->add('options', 'form_field_options')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'attr' => array(
                    'class' => 'tms_form_generator_form_field'
                ),
                'name_field' => array(
                    'type' => 'text',
                    'options' => array()
                ),
                'add_indexed_field' => false
            ))
            ->setNormalizers(array(
                'name_field' => function (Options $options, $value) {
                    if ($value) {
                        $value['options'] = array_merge($value['options'], array(
                            'attr'        => array('class' => 'form_field_name'),
                            'constraints' => array(new NotBlank())
                        ));
                    }

                    return $value;
                }
            ));
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'form_field';
    }
}
