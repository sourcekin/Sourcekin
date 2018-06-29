<?php

use Symfony\Component\DependencyInjection\Reference;

return function(\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $container){
    $container
        ->services()

        ->set(\SourcekinBundle\Command\Projections\ProjectionCommand::class)
        ->abstract()
        ->autowire()
        ->arg('$readModels', new Reference('sourcekin.projection.read_models'))
        ->arg('$projections', new Reference('sourcekin.projection.projectors'))

        ->set(\SourcekinBundle\Command\Projections\RunProjectionCommand::class)
        ->parent(\SourcekinBundle\Command\Projections\ProjectionCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:projection:run'])
        ->autowire()

        ->set(\SourcekinBundle\Command\Projections\ResetProjectionCommand::class)
        ->parent(\SourcekinBundle\Command\Projections\ProjectionCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:projection:reset'])
        ->autowire()
        ;
};