<?php
/**
* @author Benjamin TARDY <benjamin.tardy@tessi.fr>
*/

namespace Tms\Bundle\FormGeneratorBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LuhnValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->isValid($value)) {
            $this->context->addViolation($constraint->message, array('%number%' => $value));
        }
    }

    /**
     * Check validity with Luhn algorithm
     * 
     * @param  int $value
     * @return boolean
     */
    protected function isValid($value)
    {
        $checksum = '';

        foreach (str_split(strrev((string) $value)) as $i => $d) {
            $checksum .= ((($i % 2) !== 0) ? ($d * 2) : $d);
        }

        return ((array_sum(str_split($checksum)) % 10) === 0);
    }
}
