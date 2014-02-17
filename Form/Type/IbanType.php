<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Iban;
use Tms\Bundle\FormGeneratorBundle\Form\DataTransformer\IbanTransformer;

class IbanType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new IbanTransformer();
        $builder->addModelTransformer($transformer);

        $builder
            ->add('c1', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 4em;'),
                'max_length' => 4
            ))
            ->add('c2', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 4em;'),
                'max_length' => 4
            ))
            ->add('c3', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 4em;'),
                'max_length' => 4
            ))
            ->add('c4', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 4em;'),
                'max_length' => 4
            ))
            ->add('c5', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 4em;'),
                'max_length' => 4
            ))
            ->add('c6', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 4em;'),
                'max_length' => 4
            ))
            ->add('c7', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 10em;'),
                'max_length' => 10
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'iban';
    }
}
