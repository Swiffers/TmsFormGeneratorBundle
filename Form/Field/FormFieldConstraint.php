<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Field;


class FormFieldConstraint
{
    protected $className;
    protected $options;

    /**
     * Constructor
     *
     * @param string $className
     * @param array $options
     */
    public function __construct($className, $options = array())
    {
        $this->className = $className;
        $this->options = $options;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Get Options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get Constraint
     *
     * @return Symfony\Component\Validator\Constraint
     */
    public function getConstraint($options = array())
    {
        $className = $this->className;

        return new $className($options);
    }
}

