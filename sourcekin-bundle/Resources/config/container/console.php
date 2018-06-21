<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

use Prooph\EventStore\EventStore;
use Sourcekin\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $container){
    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()
        ->bind(EventStore::class, new Reference('prooph_event_store.sourcekin_store'))
        ->bind('$connection', new Reference('doctrine.pdo.connection'))
        ->bind('$vendorDir', new Parameter('app.vendor_dir'))
        ->bind('$dbalConnection', new Reference('database_connection'))
        ->bind('$bus', new Reference('prooph_service_bus.sourcekin_command_bus'))
        ->bind('$streamNames', new Parameter('sourcekin.stream_names'))
        ->load('SourcekinBundle\\Command\\', dirname(dirname(__DIR__)) . '/Command/*Command.php' )
        ->tag('console.command')
        ;
};