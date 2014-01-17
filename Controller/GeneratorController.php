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
        $data = urldecode(base64_decode($request->query->get('data')));
        $data = mb_convert_encoding($data, "UTF-8", "ISO-8859-1");
        $data = json_decode($data, true);

        $formFieldServiceName = sprintf('tms_form_generator.form_field.%s', $type);
        $formField = $this->get($formFieldServiceName);

        $options = array(
            'name'   => $name,
            'fields' => $formField->getGenerationFields($data),
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
