<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

use Broadway\EventStore\Dbal\DBALEventStore;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $configurator) {
    $configurator->services()->defaults()->autowire()->autoconfigure()
        ->load('SourcekinBundle\\Command\\', dirname(dirname(__DIR__)).'/Command/*Command.php')
        ->tag('console.command')
        ->bind(DBALEventStore::class, new Reference('broadway.event_store.dbal'))
    ;

};