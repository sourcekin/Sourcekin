<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 30.06.18.
 */

use Sourcekin\Application;
use SourcekinBundle\DependencyInjection\Dependencies;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $container){

    $container->services()->defaults()->autoconfigure()->autowire()->private()

        ->set(\SourcekinBundle\Configuration\Directories::class)
        ->arg('$home', new Parameter('kernel.project_dir'))
        ->arg('$conf',new Parameter('kernel.conf_dir'))
        ->arg('$log', new Parameter('kernel.logs_dir'))
        ->arg('$bin', new Parameter('kernel.bin_dir'))

        ->set(\Sourcekin\Components\DependencyInjection\Dependencies::class, Dependencies::class)
        ->set(Application::class)

        // pdo connection
        ->set('doctrine.pdo.connection', PDO::class)
        ->factory([new Reference('database_connection'), 'getWrappedConnection'])
        ->tag('sourcekin.dependency', ['alias' => Dependencies::PDO])

        ->alias(PDO::class, 'doctrine.pdo.connection')


    ;
};