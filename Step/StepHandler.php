<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Step;

use Symfony\Component\Form\FormFactory;

class StepHandler implements StepHandlerInterface
{
    protected $formFactory;
    protected $identifier;
    protected $parameters;

    /**
     * Constructor
     *
     * @param FormFactory $formFactory
     * @param string $identifier
     * @param array $parameters
     */
    public function __construct(
        FormFactory $formFactory,
        $identifier,
        $parameters
    )
    {
        $this->formFactory = $formFactory;
        $this->identifier = $identifier;
        $this->parameters = $parameters;
    }

    /**
     * Get FormFactory
     *
     * @return FormFactory
     */
    protected function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * Get Identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get Parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->parameters['name'];
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->parameters['icon'];
    }

    /**
     * Get configuration form type
     *
     * @return Symfony\Component\Form\AbstractType
     */
    public function getConfigurationFormType()
    {
        $formClassName = $this->parameters['configuration_form_type'];

        return new $formClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurationForm(StepInterface $step, array $options = array())
    {
        return $this->getFormFactory()->create(
            $this->getConfigurationFormType(),
            $step,
            $options
        );
    }
}