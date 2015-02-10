<?php

namespace Tms\Bundle\FormGeneratorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Generator controller.
 *
 * @Route("{_locale}/form/generator")
 */
class GeneratorController extends Controller
{
    /**
     * Generate
     *
     * @Route("/field/generate/options", name="tms_form_generator_field_generate_options")
     * @Method("POST")
     * @Template()
     */
    public function generateFieldOptionsAction(Request $request)
    {
        $name = $request->request->get('name');
        $type = $request->request->get('type');
        $data = urldecode(base64_decode($request->request->get('data')));
        $data = json_decode($data, true);

        $formFieldTypeServiceName = sprintf('tms_form_generator.form_field.type.%s', $type);
        $formFieldType = $this->get($formFieldTypeServiceName);

        $options = array(
            'name'   => $name,
            'fields' => $formFieldType->getGenerationFields($data),
        );

        $form = $this
            ->get('tms_form_generator.form_builder_generator')
            ->generate($options)
            ->getForm()
            ->createView()
        ;

        return array('form' => $form);
    }

    /**
     * Generate
     *
     * @Route("/constraint/generate/options", name="tms_form_generator_constraint_generate_options")
     * @Method("POST")
     * @Template()
     */
    public function generateConstraintOptionsAction(Request $request)
    {
        $name = $request->request->get('name');
        $constraint = $request->request->get('constraint');
        $data = urldecode(base64_decode($request->request->get('data')));
        $data = json_decode($data, true);

        $formFieldConstraintServiceName = sprintf('tms_form_generator.form_field.constraint.%s', $constraint);
        $formFieldConstraint = $this->get($formFieldConstraintServiceName);

        $options = array(
            'name'   => $name,
            'fields' => $formFieldConstraint->getGenerationFields($data),
        );

        $form = $this
            ->get('tms_form_generator.form_builder_generator')
            ->generate($options)
            ->getForm()
            ->createView()
        ;

        return array('form' => $form);
    }
}
