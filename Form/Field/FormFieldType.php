<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Field;


class FormFieldType extends AbstractFormField
{
    protected $type;
    protected $parent;

    /**
     * Constructor
     *
     * @param string $type
     * @param FormField $parent
     * @param array $options
     */
    public function __construct($type, FormFieldType $parent = null, $options = array())
    {
        parent::__construct($options);
        $this->type = $type;
        $this->parent = $parent;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get Parent
     *
     * @return FormField
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get Options
     *
     * @return array
     */
    public function getOptions()
    {
        if (!$this->getParent()) {
            return $this->options;
        }

        $parentOptions = $this->getParent()->getOptions();
        $constraintOptions = $parentOptions['constraints'];
        unset($parentOptions['constraints']);

        return array_merge_recursive(
            $parentOptions,
            $this->options,
            array('constraints' => $constraintOptions)
        );
    }
}
