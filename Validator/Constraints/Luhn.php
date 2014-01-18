<?php

/**
* @author Benjamin TARDY <benjamin.tardy@tessi.fr>
*/

namespace Tms\Bundle\FormGeneratorBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Luhn extends Constraint
{
     public $message = '"%number%" is not a valid';
}
