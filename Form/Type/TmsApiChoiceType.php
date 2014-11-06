<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tms\Bundle\RestClientBundle\Hypermedia\Crawling\CrawlerInterface;

class TmsApiChoiceType extends AbstractType
{
    private $crawler;

    /**
     * Constructor
     *
     * @param CrawlerInterface $crawler
     */
    public function __construct(CrawlerInterface $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $crawler = $this->crawler;

        $resolver
            ->setRequired(array(
                'endpoint_name',
                'path',
                'item_value',
                'item_label'
            ))
            ->setDefaults(array(
                'choices' => function (Options $options) use ($crawler) {
                    $raw = $crawler
                        ->go($options['endpoint_name'])
                        ->find($options['path'])
                        ->getData()
                    ;

                    $choices = array();
                    foreach ($raw as $benefit) {
                        $data = $benefit->getData();
                        $choices[$data[$options['item_value']]] = $data[$options['item_label']];
                    }

                    return $choices;
                }
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tms_api_choice';
    }
}
