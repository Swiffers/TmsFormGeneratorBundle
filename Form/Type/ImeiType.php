<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tms\Bundle\FormGeneratorBundle\Form\DataTransformer\ImeiTransformer;

class ImeiType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ImeiTransformer();
        $builder->addModelTransformer($transformer);

        $builder
            ->add('tac', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 6em;'),
                'max_length' => 8
            ))
            ->add('snr', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 5em;'),
                'max_length' => 6
            ))
            ->add('ctrl', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 2em;'),
                'max_length' => 1
            ))
        ;
    }

    /**
     * {@inheritdoc}
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'constraints' => new Iban()
        ));
    }
     */

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'imei';
    }
}
