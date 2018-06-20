<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace SourcekinBundle;

use SourcekinBundle\DependencyInjection\CommandHandlersPass;
use SourcekinBundle\DependencyInjection\EventHandlersPass;
use SourcekinBundle\DependencyInjection\Extension;
use SourcekinBundle\DependencyInjection\ProjectorsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SourcekinBundle extends Bundle {

    public function build(ContainerBuilder $container) {
        $container->addCompilerPass(new CommandHandlersPass());
        $container->addCompilerPass(new ProjectorsPass());
        $container->addCompilerPass(new EventHandlersPass());
    }


}