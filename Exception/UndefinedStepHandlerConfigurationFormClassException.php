<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace Tms\Bundle\FormGeneratorBundle\Exception;

class UndefinedStepHandlerConfigurationFormClassException extends \Exception
{
    /**
     * The constructor.
     *
     * @param string $stepHandlerFormClass
     */
    public function __construct($stepHandlerFormClass)
    {
        parent::__construct(sprintf(
            'The step handler configuration form class %s is undefined.',
            $stepHandlerFormClass
        ));
    }
}
