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
            if (self::isValidJson($v)) {
                $v = json_decode($v);
            }

            if ($k === "indexed") {
                self::reverseTransformIndexed($v);
            }

            if ($k === "options") {
                self::reverseTransformOptions($v);
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
    protected static function reverseTransformIndexed(&$indexed)
    {
        $indexed = (boolean)$indexed ? "1" : "0";
    }

    /**
     * Reverse transform options
     *
     * @param array & $options
     */
    protected static function reverseTransformOptions(array &$options)
    {
        foreach ($options as $k => $v) {
            if (self::isValidJson($v)) {
                $v = json_decode($v);
            }

            if (is_array($v)) {
                self::reverseTransformOptions($v);
            }

            $options[$k] = $v;
        }
    }

    /**
     * Is valid json
     *
     * @param string $toCheck
     * @return boolean
     */
    protected static function isValidJson($toCheck)
    {
        if (empty($toCheck) || !is_string($toCheck)) {
            return false;
        }

        $regexString = '"([^"\\\\]*|\\\\["\\\\bfnrt\/]|\\\\u[0-9a-f]{4})*"';
        $regexNumber = '-?(?=[1-9]|0(?!\d))\d+(\.\d+)?([eE][+-]?\d+)?';
        $regexBoolean= 'true|false|null'; // these are actually copied from Mario's answer
        $regex = '/\A('.$regexString.'|'.$regexNumber.'|'.$regexBoolean.'|';    //string, number, boolean
        $regex.= '\[(?:(?1)(?:,(?1))*)?\s*\]|'; //arrays
        $regex.= '\{(?:\s*'.$regexString.'\s*:(?1)(?:,\s*'.$regexString.'\s*:(?1))*)?\s*\}';    //objects
        $regex.= ')\Z/is';

        return preg_match($regex, $toCheck);
    }
}

