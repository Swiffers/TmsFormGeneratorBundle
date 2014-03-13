<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Benjamin TARDY <benjamin.tardy@tessi.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Generators;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tms\Bundle\FormGeneratorBundle\Form\Type\HiddenDuplicationType;

class FormBuilderGeneratorSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        /*
            FormEvents::PRE_SET_DATA
            FormEvents::POST_SET_DATA
            FormEvents::PRE_SUBMIT
            FormEvents::SUBMIT
            FormEvents::POST_SUBMIT
        */
        return array(
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();

        foreach ($event->getForm()->all() as $field) {
            $config = $field->getConfig();
            if ($config->getType()->getInnerType() instanceof HiddenDuplicationType) {
                $sourceFieldName = $config->getOption('source_field_name');
                $data[$config->getName()] = $data[$sourceFieldName];
            }
        }

        $event->setData($data);
    }
}
