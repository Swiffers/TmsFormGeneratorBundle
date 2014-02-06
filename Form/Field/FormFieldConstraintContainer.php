<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Field;

use Tms\Bundle\FormGeneratorBundle\Exception\UndefinedFormFieldConstraintException;

class FormFieldConstraintContainer
{
    private $constraints;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->constraints = array();
    }

    /**
     * Get constraints
     *
     * @return array
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * Get constraint
     *
     * @param string $name
     * @return FormFieldConstraint
     */
    public function getConstraint($name)
    {
        if(!isset($this->constraints[$name])) {
            throw new UndefinedFormFieldConstraintException($name);
        }

        return $this->constraints[$name];
    }

    /**
     * Add constraint
     *
     * @param FormFieldConstraint $constraint
     * @param string $name
     * @return FormFieldConstraintContainer
     */
    public function addConstraint(FormFieldConstraint $constraint, $name)
    {
        $this->constraints[$name] = $constraint;

        return $this;
    }
}

