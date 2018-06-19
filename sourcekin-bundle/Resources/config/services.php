<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $container) {
    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()
        ->set('doctrine.pdo.connection', PDO::class)
        ->factory([new Reference('database_connection'), 'getWrappedConnection'])
        ->alias(\Prooph\ServiceBus\EventBus::class, new Reference('prooph_service_bus.sourcekin_event_bus'))
        ->set(AggregateTranslator::class)
        ->alias(\Prooph\EventSourcing\Aggregate\AggregateTranslator::class, AggregateTranslator::class)
        ->set(PersistenceStrategy::class, PersistenceStrategy\MySqlSingleStreamStrategy::class)
        ->set(\Prooph\EventStore\Pdo\MySqlEventStore::class)
        ->args(
            [
                new Reference('prooph_event_store.message_factory'),
                new Reference('doctrine.pdo.connection'),
            ]
        )
        ->alias(EventStore::class, \Prooph\EventStore\Pdo\MySqlEventStore::class)
        ->set(\Prooph\SnapshotStore\Pdo\PdoSnapshotStore::class)
        ->arg('$connection', new Reference('doctrine.pdo.connection'))
        ->alias(\Prooph\SnapshotStore\SnapshotStore::class, \Prooph\SnapshotStore\Pdo\PdoSnapshotStore::class)
        ->set(\Prooph\EventStoreBusBridge\EventPublisher::class)
        ->tag('prooph_event_store.sourcekin_store.plugin')
    ;

   //  $container->parameters()->set('sourcekin.projections');

};