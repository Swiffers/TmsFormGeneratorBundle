<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Validator\Constraints;

abstract class DateValidatorTool
{
    /**
     * Clean the given date
     *
     * @param mixed $value
     * @return DateTime | false if not well converted
     */
    public static function cleanDateValue($value)
    {
        if ($value instanceof \DateTime) {
            return $value;
        }

        $value = new \DateTime($value);

        return $value;
    }
}
