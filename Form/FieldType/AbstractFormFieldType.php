<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\FieldType;


abstract class AbstractFormFieldType
{
    protected $type;
    protected $parent;
    protected $options;

    /**
     * Constructor
     *
     * @param string $type
     * @param AbstractFormFieldType $parent
     * @param array $options
     */
    public function __construct($type, AbstractFormFieldType $parent = null, $options = array())
    {
        $this->type = $type;
        $this->parent = $parent;
        $this->options = $options;
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
     * @return AbstractFormFieldType
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

        return array_merge($this->getParent()->getOptions(), $this->options);
    }
}
