<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Step;

interface StepHandlerInterface
{
    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get configuration form
     *
     * @param StepInterface $step
     * @param array $options
     * @return Symfony\Component\Form\Form
     */
    public function getConfigurationForm(StepInterface $step, array $options = array());
}
