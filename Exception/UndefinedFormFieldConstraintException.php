<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Exception;

class UndefinedFormFieldConstraintException extends \Exception
{
    /**
     * The constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct(sprintf(
            'No constraint defined with name: %s',
            $name
        ));
    }
}
