<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Step;

class Step implements StepInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var integer
     */
    protected $position;

    /**
     * @var string
     */
    protected $handlerServiceId;

    /**
     * @var array
     */
    protected $generationParameters;

    /**
     * @var array
     */
    protected $contentParameters;

    /**
     * toString
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->getName());
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Step
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Step
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Step
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set handlerServiceId
     *
     * @param string $handlerServiceId
     * @return Step
     */
    public function setHandlerServiceId($handlerServiceId)
    {
        $this->handlerServiceId = $handlerServiceId;

        return $this;
    }

    /**
     * Get handlerServiceId
     *
     * @return string 
     */
    public function getHandlerServiceId()
    {
        return $this->handlerServiceId;
    }

    /**
     * Set generationParameters
     *
     * @param array $generationParameters
     * @return Step
     */
    public function setGenerationParameters($generationParameters)
    {
        $this->generationParameters = $generationParameters;

        return $this;
    }

    /**
     * Get generationParameters
     *
     * @return array 
     */
    public function getGenerationParameters()
    {
        return $this->generationParameters;
    }

    /**
     * Set contentParameters
     *
     * @param array $contentParameters
     * @return Step
     */
    public function setContentParameters($contentParameters)
    {
        $this->contentParameters = $contentParameters;

        return $this;
    }

    /**
     * Get contentParameters
     *
     * @return array
     */
    public function getContentParameters()
    {
        return $this->contentParameters;
    }
}
