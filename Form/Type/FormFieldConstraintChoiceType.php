<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormFieldConstraintChoiceType extends AbstractType
{
    /**
     * @var array
     */
    private $formFieldConstraints;

    /**
     * Constructor
     *
     * @param array $formFieldConstraints
     */
    public function __construct($formFieldConstraints)
    {
        foreach($formFieldConstraints as $id => $formFieldConstraint) {
            $alias = isset($formFieldConstraint['alias']) ? $formFieldConstraint['alias'] : $id;
            $this->formFieldConstraints[$id] = $alias;
        }

        asort($this->formFieldConstraints);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->formFieldConstraints,
            'attr'    => array('class' => 'form_field_constraint_choice')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'form_field_constraint_choice';
    }
}
