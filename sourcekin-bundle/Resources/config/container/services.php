<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 30.06.18.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;

return function(ContainerConfigurator $container){

    $container->services()->defaults()->autoconfigure()->autowire()->private()

        ->set(\SourcekinBundle\Configuration\Directories::class)
        ->arg('$home', new Parameter('kernel.project_dir'))
        ->arg('$conf',new Parameter('kernel.conf_dir'))
        ->arg('$log', new Parameter('kernel.logs_dir'))
        ->arg('$bin', new Parameter('kernel.bin_dir'))
        ;
};