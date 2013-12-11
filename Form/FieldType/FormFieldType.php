<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\FieldType;


class FormFieldType
{
    protected $type;
    protected $parent;
    protected $options;

    /**
     * Constructor
     *
     * @param string $type
     * @param FormFieldType $parent
     * @param array $options
     */
    public function __construct($type, FormFieldType $parent = null, $options = array())
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
     * @return FormFieldType
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

        return array_merge_recursive($this->getParent()->getOptions(), $this->options);
    }

    /**
     * Get fields raw
     *
     * @return array
     */
    public function getFieldsRaw()
    {
        $fields = array();
        foreach($this->getOptions() as $name => $parameters) {
            $fields[] = array(
                'name' => $name,
                'type' => $parameters['type'],
                'parameters' => isset($parameters['options']) ? $parameters['options'] : array()
            );
        }

        return array('fields' => $fields);
    }
}
