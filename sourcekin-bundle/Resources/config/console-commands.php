<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $container){

    $container
        ->services()->defaults()->autowire()->autoconfigure()

        // ->bind('$connection', new Reference('doctrine.pdo.connection'))
        // ->bind('$vendorDir', new Parameter('app.vendor_dir'))
        ->bind('$dbalConnection', new Reference('database_connection'))

        ->set(\SourcekinBundle\Command\RunProjectionCommand::class)
        ->arg('$projections', new Reference('sourcekin.projection.projectors'))
        ->arg('$readModels', new Reference('sourcekin.projection.read_models'))

        ->tag('console.command', ['command' => 'sourcekin:projection:run'])

        ->set(\SourcekinBundle\Command\InstallCommand::class)
        ->arg('$streamNames', ['user_events'])
        ->tag('console.command', ['command' => 'sourcekin:install'])

        ->set(\SourcekinBundle\Command\MakeUserCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:make:user'])
        ;


};