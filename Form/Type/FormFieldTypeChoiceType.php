<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormFieldTypeChoiceType extends AbstractType
{
    /**
     * @var array
     */
    private $formFieldTypes;

    /**
     * Constructor
     *
     * @param array $formFieldTypes
     */
    public function __construct($formFieldTypes)
    {
        foreach($formFieldTypes as $id => $formFieldType) {
            if ($formFieldType['abstract'] === "false" || !$formFieldType['abstract']) {
                $alias = isset($formFieldType['alias']) ? $formFieldType['alias'] : $id;
                $this->formFieldTypes[$id] = $alias;
            }
        }

        asort($this->formFieldTypes);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->formFieldTypes,
            'attr'    => array('class' => 'form_field_type_choice')
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
        return 'form_field_type_choice';
    }
}
