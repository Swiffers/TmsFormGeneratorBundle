<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Field;


class FormFieldConstraint extends AbstractFormField
{
    protected $className;

    /**
     * Constructor
     *
     * @param string $className
     * @param array $options
     */
    public function __construct($className, $options = array())
    {
        parent::__construct($options);
        $this->className = $className;
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
     * Create form constraint
     *
     * @return Symfony\Component\Validator\Constraint
     */
    public function createFormConstraint($options = array())
    {
        $className = $this->className;

        return new $className($options);
    }
}

