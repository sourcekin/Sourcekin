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

        ->bind('$dbalConnection', new Reference('database_connection'))

        ->set(\SourcekinBundle\Command\InstallCommand::class)
        ->arg('$streamNames', new Parameter('sourcekin.stream_names'))
        ->tag('console.command', ['command' => 'sourcekin:install'])


        ->set(\SourcekinBundle\Command\ConfigureSupervisorCommand::class)
        ->arg('$projections', new Parameter('sourcekin.projections'))
        ->arg('$confDir', new Parameter('kernel.project_dir'))
        ->tag('console.command', ['command' => 'sourcekin:configure:supervisor'])


        ->set(\SourcekinBundle\Command\MakeUserCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:make:user'])


        ->set(\SourcekinBundle\Command\MakeDocumentCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:make-document'])

        ->set(\SourcekinBundle\Command\FindDocumentCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:find:document'])

;
};