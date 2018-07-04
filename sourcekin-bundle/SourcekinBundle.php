<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace SourcekinBundle;

use SourcekinBundle\DependencyInjection\Compiler\CommandHandlersPass;
use SourcekinBundle\DependencyInjection\Compiler\DependenciesPass;
use SourcekinBundle\DependencyInjection\Compiler\EventHandlersPass;
use SourcekinBundle\DependencyInjection\Compiler\ProjectorsPass;
use SourcekinBundle\DependencyInjection\Compiler\QueryHandlersPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SourcekinBundle extends Bundle {

    public function build(ContainerBuilder $container) {

        $container->addCompilerPass(new DependenciesPass());
        $container->addCompilerPass(new CommandHandlersPass());
        $container->addCompilerPass(new EventHandlersPass());
        $container->addCompilerPass(new QueryHandlersPass());
        $container->addCompilerPass(new ProjectorsPass());


    }


}