<?php
namespace Tms\Bundle\FormGeneratorBundle\Generators;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tms\Bundle\FormGeneratorBundle\Exceptions\ConstraintNotFoundException;

/**
 *  @author Benjamin TARDY <benjamin.tardy@tessi.fr>
 */
class FormBuilderGenerator implements GeneratorInterface
{
    /**
     * Instance of a form factory
     *
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * User defined constraints
     * ex : array(
     *     'NotBlank' => '\Symfony\Component\Validator\Constraints\NotBlank',
     * ):
     *
     * @var array
     */
    protected $userConstraints;

    /**
     * FormGenerator constructor
     *
     * @param FormFactoryInterface $formFactory Instance of FormFactory
     * @param array $constraints User defined constraints
     */
    public function __construct(FormFactoryInterface $formFactory, array $userConstraints = null)
    {
        $this->formFactory     = $formFactory;
        $this->userConstraints = is_array($userConstraints) ? $userConstraints : array();
    }

    /**
     * setDefaultFormOptions
     *
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultFormOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'fields'  => array(),
            'name'    => null,
            'options' => array('csrf_protection' => false)
        ));
    }

    /**
     * setDefaultFieldOptions
     *
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultFieldOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('name', 'type'))
            ->setDefaults(array(
                'options'     => array(),
                'constraints' => array(),
                'eligibility' => array(),
                'indexed'     => false
            ))
            ->setNormalizers(array(
                'options' => function (Options $options, $values) {
                    if (!$values) {
                        return array();
                    }

                    foreach ($values as $k => $v) {
                        if (!is_bool($v) && empty($v)) {
                            unset($values[$k]);
                        }
                    }

                    return $values;
                },
                'constraints' => function (Options $options, $values) {
                    if (!$values) {
                        return array();
                    }

                    return $values;
                },
                'eligibility' => function (Options $options, $values) {
                    if (!$values) {
                        return array();
                    }

                    return $values;
                },
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(array $options = array())
    {
        $resolver = new OptionsResolver();
        $this->setDefaultFormOptions($resolver);
        $parameters = $resolver->resolve($options);

        $formBuilder = $this->formFactory->createBuilder(
            'form',
            null,
            $parameters['options']
        );

        if ($parameters['name']) {
            $formBuilder = $this->formFactory->createNamedBuilder(
                $parameters['name'],
                'form',
                null,
                $parameters['options']
            );
        }

        foreach ($parameters['fields'] as $field) {
            $this->generateField($formBuilder, $field);
        }

        return $formBuilder;
    }

    /**
     * {@inheritDoc}
     */
    protected function generateField(FormBuilderInterface & $formBuilder, array $options = array())
    {
        $resolver = new OptionsResolver();
        $this->setDefaultFieldOptions($resolver);
        $parameters = $resolver->resolve($options);

        $formBuilder->add($parameters['name'], $parameters['type'], $parameters['options']);
    }

    /**
     * Generate a new Constraint based on the given name and options
     *
     * @param  string     $name    Constraint name
     * @param  array      $options Constraint options
     * @return Constraint
     */
    protected function generateConstraint($name, array $options = array())
    {
        // First step : Find constraint namespace an class
        $className = $this->findConstraintClassName($name);

        // Second step: Instanciate the constraint with his options
        $constraint = new $className($options);

        // Last step: Check Constraint type
        if (! ($constraint instanceof Constraint)) {
            throw new BadConstraintTypeException(sprintf('%s is not a Constraint', $className));
        }

        return $constraint;
    }

    /**
     * Find the class namespace of a constraint
     *
     * @param  string $name Constraint name
     * @return string
     */
    protected function findConstraintClassName($name)
    {
        // First step: Search in user-defined constraints
        if (isset($this->userConstraints[$name])) {
            return $this->userConstraints[$name];
        }

        // Next step: Search in symfony2 constraints
        $className = sprintf('\Symfony\Component\Validator\Constraints\%s', $name);
        if (class_exists($className)) {
            return $className;
        }

        // Last step: Constraint not found, throw an exception
        throw new ConstraintNotFoundException(sprintf('The constraint %s was not found', $name));
    }
}
