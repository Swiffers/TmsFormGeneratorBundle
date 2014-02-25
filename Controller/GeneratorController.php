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
     * @Method("GET")
     * @Template()
     */
    public function generateFieldOptionsAction(Request $request)
    {
        $name = $request->query->get('name');
        $type = $request->query->get('type');
        $data = urldecode(base64_decode($request->query->get('data')));
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
     * @Method("GET")
     * @Template()
     */
    public function generateConstraintOptionsAction(Request $request)
    {
        $name = $request->query->get('name');
        $constraint = $request->query->get('constraint');
        $data = urldecode(base64_decode($request->query->get('data')));
        $data = mb_convert_encoding($data, "UTF-8", "ISO-8859-1");
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
