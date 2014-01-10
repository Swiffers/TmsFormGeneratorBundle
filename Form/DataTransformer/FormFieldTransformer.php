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

        $reverseTransformed = array();
        foreach ($out as $k => $v) {
            if ($k === "indexed") {
                self::reverseTransformIndexed($v);
            }

            if ($k === "options") {
                self::reverseTransformOptions($v);
            }

            if ($k === "constraints") {
                self::reverseTransformConstraints($v);
            }

            $reverseTransformed[$k] = $v;
        }

        return json_encode($reverseTransformed);
    }

    /**
     * Reverse transform indexed
     *
     * @param string & $indexed
     */
    protected function reverseTransformIndexed(&$indexed)
    {
        $indexed = (boolean)$indexed ? "1" : "0";
    }

    /**
     * Reverse transform options
     *
     * @param array & $options
     */
    protected function reverseTransformOptions(array &$options)
    {
        foreach ($options as $k => $v) {
            if(self::isValidJson($v)) {
                $options[$k] = json_decode($v, true);
            }
        }
    }

    /**
     * Reverse transform constraints
     *
     * @param array | string & $constraints
     */
    protected function reverseTransformConstraints(&$constraints)
    {
        if(self::isValidJson($constraints)) {
            $constraints = json_decode($constraints, true);
        }
    }

    /**
     * Is valid json
     *
     * @param string $toCheck
     * @return boolean
     */
    protected function isValidJson($toCheck)
    {
         return !empty($toCheck) && is_string($toCheck) && is_array(json_decode($toCheck, true)) && json_last_error() == 0;
    }
}

