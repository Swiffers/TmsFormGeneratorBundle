<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class FormFieldOptionsTransformer implements DataTransformerInterface
{
    /**
     * Transforms
     *
     * @param array $in
     * @return string
     */
    public function transform($in)
    {
        return json_encode($in);
    }

    /**
     * Reverse transforms
     *
     * @param string $out
     * @return array
     */
    public function reverseTransform($out)
    {
        return $out;
    }
}

