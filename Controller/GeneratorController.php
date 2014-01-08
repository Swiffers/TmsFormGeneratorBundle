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
     * @Route("/generate/parameters", name="tms_form_generator_generate_parameters")
     * @Method("GET")
     * @Template()
     */
    public function generateParametersAction(Request $request)
    {
        $name = $request->query->get('name');
        $type = $request->query->get('type');
        $data = json_decode(base64_decode($request->query->get('data')), true);

        $formFieldServiceName = sprintf('tms_form_generator.form_field.%s', $type);
        $formField = $this->get($formFieldServiceName);

        $options = array(
            'name'   => $name,
            'fields' => $formField->getGenerationFields($data),
        );

        $form = $this
            ->get('tms_form_generator.builder')
            ->generate($options)
            ->getForm()
            ->createView()
        ;

        return array('form' => $form);
    }
}
