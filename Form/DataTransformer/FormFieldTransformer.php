<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class FormFieldTransformer implements DataTransformerInterface
{
    /**
     * Transforms
     *
     * @param string $in
     * @return array
     */
    public function transform($in)
    {
        if (null === $in) {
            return array();
        }

        if (is_array($in)) {
            return $in;
        }

        $transformed = array();
        $data = json_decode($in, true);
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $v = json_encode($v);
            }

            $transformed[$k] = $v;
        }

        return $transformed;
    }

    /**
     * Reverse transforms
     *
     * @param array $out
     * @return string
     */
    public function reverseTransform($out)
    {
        if (null === $out) {
            return '';
        }

        return json_encode($out);
    }
}

