<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class Ean13ConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // check to see if barcode is 13 digits long
        if (!preg_match("/^[0-9]{13}$/", $value)) {
            $this->context->addViolation(
                $constraint->message,
                array('%value%' => $value)
            );
        }

        $digits = $barcode;

        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $evenSum = $value[1] + $value[3] + $value[5] + $value[7] + $value[9] + $value[11];

        // 2. Multiply this result by 3.
        $evenSumThree = $evenSum * 3;

        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $oddSum = $value[0] + $value[2] + $value[4] + $value[6] + $value[8] + $value[10];

        // 4. Sum the results of steps 2 and 3.
        $totalSum = $evenSumThree + $oddSum;

        // 5. The check character is the smallest number which, when added to the result in step 4, produces a multiple of 10.
        $nextTen = (ceil($totalSum / 10)) * 10;
        $checkDigit = $nextTen - $totalSum;

        // if the check digit and the last digit of the barcode are OK return true;
        if ($checkDigit != $digits[12]) {
            $this->context->addViolation(
                $constraint->message,
                array('%value%' => $value)
            );
        }
    }
}
