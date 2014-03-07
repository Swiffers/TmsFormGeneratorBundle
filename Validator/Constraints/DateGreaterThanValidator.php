<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\GreaterThanValidator;

class DateGreaterThanValidator extends GreaterThanValidator
{
    /**
     * @inheritDoc
     */
    protected function compareValues($value1, $value2)
    {
        $value2 = new \DateTime($value2);
        if (!$value2) {
            return false;
        }

        return parent::compareValues($value1, $value2);
    }
}
