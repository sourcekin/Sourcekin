<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace SourcekinBundle;

use Sourcekin\Infrastructure\DependencyInjection\Compiler\InitializeDomainPass;
use SourcekinBundle\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SourcekinBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new InitializeDomainPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 100);
    }

    public function getContainerExtension()
    {
        return new Extension();
    }


}