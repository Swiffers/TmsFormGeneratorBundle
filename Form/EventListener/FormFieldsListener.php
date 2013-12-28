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

class FormFieldsListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $options;

    /**
     * {@inheritdoc}
     */
    public function __construct($type, array $options = array())
    {
        $this->type = $type;
        $this->options = $options;
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
            $data = json_decode($data, true);
            $event->setData($data['fields']);
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
            if ($count > 0) {
                $glue = ',';
            }
            $jsonFields .= $glue.$data;
            $count++;
        }

        $event->setData(sprintf('{"fields": [%s]} ',
            $jsonFields
        ));
    }
}
