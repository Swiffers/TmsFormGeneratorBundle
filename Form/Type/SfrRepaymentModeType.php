<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SfrRepaymentModeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array(
            'iban_field_class' => $options['iban_field_class'],
            'repayment_mode_field_class' => $options['repayment_mode_field_class'],
            'checked_repayment_mode_value' => $options['checked_repayment_mode_value'],
            'unchecked_repayment_mode_value' => $options['unchecked_repayment_mode_value']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'iban_field_class',
            'repayment_mode_field_class',
            'checked_repayment_mode_value',
            'unchecked_repayment_mode_value'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sfr_repayment_mode';
    }
}
