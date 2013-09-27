<?php
namespace Tms\Bundle\FormGeneratorBundle\Generators;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraint;
use Tms\Bundle\FormGeneratorBundle\Exceptions\ConstraintNotFoundException;
use Tms\Bundle\FormGeneratorBundle\Exceptions\MissingParametersException;

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
     * @param array                $constraints User defined constraints
     */
    public function __construct (FormFactoryInterface $formFactory, array $userConstraints = null)
    {
        $this->formFactory     = $formFactory;
        $this->userConstraints = is_array($userConstraints) ? $userConstraints : array();
    }

    /**
     * {@inheritDoc}
     */
    public function generate (array $parameters = array())
    {
        $formBuilder = $this->formFactory->createBuilder();

        if (isset($parameters['fields'])) {
            foreach ($parameters['fields'] as $field) {
                if (isset($field['name'], $field['type'])) {
                    $parameters  = isset($field['parameters'])  ? $field['parameters']  : array();
                    $constraints = isset($field['constraints']) ? $field['constraints'] : array();

                    foreach ($constraints as $name => $options) {
                        $options = is_array($options) ? $options : array();

                        $parameters['constraints'][] = $this->generateConstraint($name, $options);
                    }

                    $formBuilder->add($field['name'], $field['type'], $parameters);
                } else {
                    throw new MissingParametersException('A Field Must have at least a name and a type');
                }
            }
        }

        return $formBuilder;
    }

    /**
     * Generate a new Constraint based on the given name and options
     * 
     * @param  string     $name    Constraint name
     * @param  array      $options Constraint options
     * @return Constraint
     */
    protected function generateConstraint ($name, array $options = array())
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
    protected function findConstraintClassName ($name)
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