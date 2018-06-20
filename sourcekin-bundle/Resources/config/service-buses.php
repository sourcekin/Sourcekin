<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

use Prooph\Common\Event\ActionEventEmitter;
use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\Common\Messaging\MessageFactory;
use Prooph\EventSourcing\Aggregate\AggregateTranslator;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\MySqlEventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy;
use Prooph\EventStore\Pdo\Projection\MySqlProjectionManager;
use Prooph\EventStore\Projection\ProjectionManager;
use Prooph\EventStoreBusBridge\EventPublisher;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Prooph\ServiceBus\Plugin\Router\ServiceLocatorEventRouter;
use Prooph\ServiceBus\Plugin\Router\SingleHandlerServiceLocatorRouter;
use Prooph\SnapshotStore\Pdo\PdoSnapshotStore;
use Prooph\SnapshotStore\SnapshotStore;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

return function(ContainerConfigurator $container){

    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()
        ->set('doctrine.pdo.connection', PDO::class)
        ->factory([new Reference('database_connection'), 'getWrappedConnection'])
        ->lazy()
        ->alias(PDO::class, 'doctrine.pdo.connection')

        // factories
        ->set('sourcekin.command_bus.factory', \SourcekinBundle\Factory\CommandBusFactory::class)
        ->set('sourcekin.event_bus.factory', \SourcekinBundle\Factory\EventBusFactory::class)

        ->set(AggregateTranslator::class, \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class )

        // event store
        ->set('sourcekin.event_store', MySqlEventStore::class)
        ->set(MessageFactory::class, FQCNMessageFactory::class)
        ->set(PersistenceStrategy::class, PersistenceStrategy\MySqlSingleStreamStrategy::class)
        // event emitter
        ->set(ActionEventEmitter::class, ProophActionEventEmitter::class)
        ->set(ActionEventEmitterEventStore::class)
        ->arg('$eventStore', new Reference('sourcekin.event_store'))
        ->alias(EventStore::class, ActionEventEmitterEventStore::class)

        // service-locators
        ->set('sourcekin.event_handlers'  , ServiceLocator::class)
        ->set('sourcekin.command_handlers', ServiceLocator::class)
        ->set('sourcekin.projection.projectors', ServiceLocator::class)
        ->set('sourcekin.projection.read_models', ServiceLocator::class)

        // event bus
        ->set(EventBus::class)->factory([new Reference('sourcekin.event_bus.factory'), 'compose'])
        ->set(EventPublisher::class)

        // event router
        ->set(EventRouter::class, ServiceLocatorEventRouter::class)->arg('$container', new Reference('sourcekin.event_handlers'))
        ->alias('sourcekin.event_router', EventRouter::class)

        // command bus
        ->set(CommandBus::class)
        ->factory([new Reference('sourcekin.command_bus.factory'), 'compose'])
        ->arg('$router', new Reference('sourcekin.command_router'))

        ->set('sourcekin.command_bus.router.single_handler_locator', SingleHandlerServiceLocatorRouter::class)
        ->arg('$container', new Reference('sourcekin.command_handlers'))
        ->alias('sourcekin.command_router', 'sourcekin.command_bus.router.single_handler_locator')

        // snapshot
        ->set(SnapshotStore::class, PdoSnapshotStore::class)

        // projection manager
        ->set(ProjectionManager::class, MySqlProjectionManager::class)

        ;


};