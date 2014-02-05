<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\EventListener;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormFieldOptionsCleanerListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        $this->name = $name;
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
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        $format = '[%s]';
        if ($this->getName()) {
            $format = '{"'.$this->getName().'": [%s]}';
        }

        return $format;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => array('preSetData', 10),
            FormEvents::SUBMIT => array('onSubmit', 40)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (empty($data)) {
            $event->setData(array());
        } else {
            if (!is_array($data)) {
                $data = json_decode($data, true);
            }
            // Keep the options field in string which is tranform to an array with js
            $data = null === $this->getName() ? $data : $data[$this->getName()];
            foreach($data as &$dataField) {
                $dataField['options'] = json_encode($dataField['options']);
            }

            $event->setData($data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onSubmit(FormEvent $event)
    {
        $jsonFields = '';
        $glue = '';
        $count = 0;
        foreach ($event->getData() as $data) {
            if (is_array($data)) {
                $data = json_encode($data);
            }

            if ($count > 0) {
                $glue = ',';
            }
            $jsonFields .= $glue.$data;
            $count++;
        }

        $event->setData(sprintf($this->getFormat(),
            $jsonFields
        ));
    }
}
