<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace Tms\Bundle\FormGeneratorBundle\Exception;

class UndefinedStepHandlerException extends \Exception
{
    /**
     * The constructor.
     *
     * @param string $stepHandlerId
     */
    public function __construct($stepHandlerId)
    {
        parent::__construct(sprintf(
            'The step handler %s is undefined.',
            $stepHandlerId
        ));
    }
}
