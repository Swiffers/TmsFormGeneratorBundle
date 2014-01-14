<?php

/**
* @author Benjamin TARDY <benjamin.tardy@tessi.fr>
*/

namespace Tms\Bundle\FormGeneratorBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Imei extends Constraint
{
    public $format = 'Imei format is not valid';
    public $value  = 'Imei number is not valid';
}
