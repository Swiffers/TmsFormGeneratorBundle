<?php
namespace Tms\Bundle\FormGeneratorBundle\Generators;

/**
 *  @author Benjamin TARDY <benjamin.tardy@tessi.fr>
 */
interface GeneratorInterface
{
    /**
     * Generate an object
     * 
     * @param  array  $parameters Parameters used to generate the object
     * @return mixed              The generated object
     */
    public function generate(array $parameters = array());
}