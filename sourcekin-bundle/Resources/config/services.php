<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

use Prooph\Common\Event\ActionEventEmitter;
use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\MySqlEventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $container){
    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()
        ->set('sourcekin.connection', PDO::class)
        ->args([new Parameter('app.connection.dsn'), new Parameter('app.connection.user'), new Parameter('app.connection.name')])
        ->set(FQCNMessageFactory::class)
        ->set(PersistenceStrategy::class, PersistenceStrategy\MySqlAggregateStreamStrategy::class)

        ->set(EventStore::class, MySqlEventStore::class)
        ->arg('$connection', new Reference('sourcekin.connection'))

        ->set(ActionEventEmitter::class, ProophActionEventEmitter::class)
        ->set(ActionEventEmitterEventStore::class)

        ;

};