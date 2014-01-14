<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ImeiTransformer implements DataTransformerInterface
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
                'tac'  => substr($in, 0, 8),
                'snr'  => substr($in, 8, 6),
                'ctrl' => substr($in, 14)
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
            return sprintf('%d%d%d',
                $out['tac'],
                $out['snr'],
                $out['ctrl']
            );
        }

        return $out;
    }
}

