<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Step;

use Tms\Bundle\FormGeneratorBundle\Exception\UndefinedStepHandlerException;

class StepContainer
{
    protected $stepHandlers;

    /**
     * Set step handler
     *
     * @param string $stepHandlerId
     * @param StepHandlerInterface $stepHandler
     */
    public function setStepHandler($stepHandlerId, StepHandlerInterface $stepHandler)
    {
        $this->stepHandlers[$stepHandlerId] = $stepHandler;
    }

    /**
     * Get step handler
     *
     * @param  string stepHandlerServiceName
     * @return StepHandlerInterface
     * @throw  UndefinedStepHandlerException
     */
    public function getStepHandler($stepHandlerId)
    {
        if (isset($this->stepHandlers[$stepHandlerId])) {
            return $this->stepHandlers[$stepHandlerId];
        }

        throw new UndefinedStepHandlerException($stepHandlerId);
    }
}
