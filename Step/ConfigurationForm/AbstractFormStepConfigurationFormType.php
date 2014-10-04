<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Step\ConfigurationForm;

use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractFormStepConfigurationFormType extends AbstractStepConfigurationFormType
{
    /**
     * {@inheritdoc}
     */
    public function hasGenerationParameters()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentParameters(array $options = array())
    {
        return array();
    }
}
