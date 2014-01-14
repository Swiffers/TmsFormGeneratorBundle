<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class IbanTransformer implements DataTransformerInterface
{
    /**
     * Transforms
     *
     * @param string $in
     * @return array
     */
    public function transform($in)
    {
        if (null !== $in && !is_array($in)) {
            return array(
                'country_code'   => substr($in, 0, 2),
                'checksum'       => substr($in, 2, 2),
                'account_number' => substr($in, 4)
            );
        }

        return $in;
    }

    /**
     * Reverse transforms
     *
     * @param array $out
     * @return string
     */
    public function reverseTransform($out)
    {
        if (null !== $out && is_array($out)) {
            return sprintf('%s%s%s',
                $out['country_code'],
                $out['checksum'],
                $out['account_number']
            );
        }

        return $out;
    }
}

