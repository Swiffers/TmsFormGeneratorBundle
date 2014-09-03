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
     * @param  array $options Options used to generate the form
     * @param  array $data    Data used to set default values
     * @return FormBuilderInterface The generated form
     */
    public function generate(array $options = array(), $data = array());
}
