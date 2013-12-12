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
     * @param array $options Options used to generate the form
     * @return FormBuilderInterface The generated form
     */
    public function generate(array $options = array());
}
