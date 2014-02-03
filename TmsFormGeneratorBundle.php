<?php
namespace Tms\Bundle\FormGeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tms\Bundle\FormGeneratorBundle\DependencyInjection\Compiler\FormFieldTypeCompilerPass;
use Tms\Bundle\FormGeneratorBundle\DependencyInjection\Compiler\FormFieldConstraintCompilerPass;

class TmsFormGeneratorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormFieldTypeCompilerPass());
        $container->addCompilerPass(new FormFieldConstraintCompilerPass());
    }
}
