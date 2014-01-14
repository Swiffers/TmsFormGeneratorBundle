<?php
/**
* @author Benjamin TARDY <benjamin.tardy@tessi.fr>
*/

namespace Tms\Bundle\FormGeneratorBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImeiValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate ($imei, Constraint $constraint)
    {
        // Check IMEI format
        if (!preg_match('/^[0-9]{15}$/', $imei)) {
             $this->context->addViolation($constraint->format);
        }

        // Check IMEI validity
        if (!$this->isValid($imei)) {
            $this->context->addViolation($constraint->value);
        }
    }

    /**
     * Check IMEI validity with Luhn algorithm
     * 
     * @param  int $imei IMEI number
     * @return boolean
     */
    protected function isValid ($imei)
    {
        $checksum = '';

        foreach (str_split(strrev((string) $imei)) as $i => $d) {
            $checksum .= ((($i % 2) !== 0) ? ($d * 2) : $d);
        }

        return ((array_sum(str_split($checksum)) % 10) === 0);
    }
}
