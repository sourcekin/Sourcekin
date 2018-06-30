<?php

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

return function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $container) {
    $container
        ->services()
        // elastic search builder
        ->set(ClientBuilder::class)
        ->factory([ClientBuilder::class, 'create'])
        // ES-Client
        ->set(Client::class)
        ->factory([new Reference(ClientBuilder::class), 'fromConfig'])
        ->arg('$config', [
                'hosts'  => new Parameter('app.elasticsearch.hosts'),
                'logger' => new Reference('logger'),
        ])

        // base projection command
        ->set(\SourcekinBundle\Command\Projections\ProjectionCommand::class)
        ->abstract()
        ->autowire()
        ->arg('$readModels', new Reference('sourcekin.projection.read_models'))
        ->arg('$projections', new Reference('sourcekin.projection.projectors'))

        // run projections
        ->set(\SourcekinBundle\Command\Projections\RunProjectionCommand::class)
        ->parent(\SourcekinBundle\Command\Projections\ProjectionCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:projection:run'])
        ->autowire()

        // reset projections
        ->set(\SourcekinBundle\Command\Projections\ResetProjectionCommand::class)
        ->parent(\SourcekinBundle\Command\Projections\ProjectionCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:projection:reset'])
        ->autowire()

        // stop projection
        ->set(\SourcekinBundle\Command\Projections\StopProjectionCommand::class)
        ->parent(\SourcekinBundle\Command\Projections\ProjectionCommand::class)
        ->tag('console.command', ['command' => 'sourcekin:projection:stop'])
        ->autowire()
    ;
};