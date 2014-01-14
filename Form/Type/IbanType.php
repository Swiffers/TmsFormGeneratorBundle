<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Intl\Intl;
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
            ->add('country_code', 'choice', array(
                'label'      => ' ',
                'choices'    => array_combine(
                    array_keys(Intl::getRegionBundle()->getCountryNames()),
                    array_keys(Intl::getRegionBundle()->getCountryNames())
                )
            ))
            ->add('checksum', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 2.5em;'),
                'max_length' => 2
            ))
            ->add('account_number', 'text', array(
                'label'      => ' ',
                'attr'       => array('style' => 'width: 18.5em;'),
                'max_length' => 30
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'constraints' => new Iban()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'iban';
    }
}
