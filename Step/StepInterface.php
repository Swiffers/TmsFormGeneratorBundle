<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Step;

interface StepInterface
{
    /**
     * Get handlerServiceId
     *
     * @return string
     */
    public function getHandlerServiceId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition();

    /**
     * Get generationParameters
     *
     * @return array
     */
    public function getGenerationParameters();

    /**
     * Get contentParameters
     *
     * @return array
     */
    public function getContentParameters();
}
