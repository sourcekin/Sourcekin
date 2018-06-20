<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace SourcekinBundle;

use SourcekinBundle\DependencyInjection\Compiler\BusPluginsPass;
use SourcekinBundle\DependencyInjection\Compiler\CommandHandlersPass;
use SourcekinBundle\DependencyInjection\Compiler\EventHandlersPass;
use SourcekinBundle\DependencyInjection\Compiler\ProjectorsPass;
use SourcekinBundle\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SourcekinBundle extends Bundle {

    public function build(ContainerBuilder $container) {
        $container->addCompilerPass(new CommandHandlersPass());
        $container->addCompilerPass(new ProjectorsPass());
        $container->addCompilerPass(new EventHandlersPass());
        $container->addCompilerPass(new BusPluginsPass());
    }


}