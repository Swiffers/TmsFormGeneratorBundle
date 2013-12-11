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
 * @Route("/form/generator")
 */
class GeneratorController extends Controller
{
    /**
     * Generate
     *
     * @Route("/generate/parameters", name="tms_form_generator_generate_parameters")
     * @Method("GET")
     * @Template()
     */
    public function generateParametersAction(Request $request)
    {
        $type = $request->query->get('type');
        $data = $request->query->get('data');

        $formFieldServiceName = sprintf('tms_form_generator.form_field.%s', $type);
        $formField = $this->get($formFieldServiceName);

        $form = $this
            ->get('tms_form_generator.builder')
            ->generate($formField->getFieldsRaw())
            ->getForm()
            ->createView()
        ;

        return array('form' => $form);
    }
}
