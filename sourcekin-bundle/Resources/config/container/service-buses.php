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
use SourcekinBundle\ServiceBus\CommandBus;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Prooph\ServiceBus\Plugin\Router\SingleHandlerServiceLocatorRouter;
use Prooph\SnapshotStore\Pdo\PdoSnapshotStore;
use Prooph\SnapshotStore\SnapshotStore;
use Prooph\ServiceBus\EventBus;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

return function (ContainerConfigurator $container) {

    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()
        ->set('doctrine.pdo.connection', PDO::class)
        ->factory([new Reference('database_connection'), 'getWrappedConnection'])
        ->lazy()
        ->alias(PDO::class, 'doctrine.pdo.connection')
        // translator
        ->set(AggregateTranslator::class, \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class)
        // factories
        ->set('sourcekin.command_bus.factory', \SourcekinBundle\Factory\CommandBusFactory::class)
        ->set('sourcekin.event_bus.factory', \SourcekinBundle\Factory\EventBusFactory::class)
        ->set('sourcekin.event_store.factory', \SourcekinBundle\Factory\EventStoreFactory::class)
        // command router
        ->set('sourcekin.command_bus.router.single_handler_locator', SingleHandlerServiceLocatorRouter::class)
        ->arg('$container', new Reference('sourcekin.command_handlers'))
        ->alias('sourcekin.command_router', 'sourcekin.command_bus.router.single_handler_locator')
        // service-locators
        ->set('sourcekin.command_handlers', ServiceLocator::class)
        ->set('sourcekin.projection.projectors', ServiceLocator::class)
        ->set('sourcekin.projection.read_models', ServiceLocator::class)
        // event router
        ->set(EventRouter::class)
        ->alias('sourcekin.event_router', EventRouter::class)
        // event store
        ->set(MySqlEventStore::class)
        ->set(MessageFactory::class, FQCNMessageFactory::class)
        ->set(PersistenceStrategy::class, PersistenceStrategy\MySqlSingleStreamStrategy::class)
        // event emitter
        ->set(ActionEventEmitter::class, ProophActionEventEmitter::class)
        ->set(ActionEventEmitterEventStore::class)
        ->factory([new Reference('sourcekin.event_store.factory'), 'decorate'])
        ->arg('$eventStore', new Reference(MySqlEventStore::class))
        ->arg('$router', new Reference('sourcekin.event_router'))
        ->alias(EventStore::class, ActionEventEmitterEventStore::class)

        // event bus
        ->set(EventBus::class, \SourcekinBundle\ServiceBus\EventBus::class)
        ->tag('sourcekin.service_bus')
        ->call('addPlugin', [new Reference('sourcekin.event_bus.logger')])
        ->alias('sourcekin.event_bus', EventBus::class)

        // command bus
        ->set(CommandBus::class)
        ->factory([new Reference('sourcekin.command_bus.factory'), 'compose'])
        ->arg('$router', new Reference('sourcekin.command_router'))
        ->tag('sourcekin.service_bus')
        ->call('addPlugin', [new Reference('sourcekin.command_bus.logger')])
        ->alias(\Prooph\ServiceBus\CommandBus::class, new Reference(CommandBus::class))
        ->alias('sourcekin.command_bus', new Reference(CommandBus::class))

        ->set('sourcekin.command_bus.router.single_handler_locator', SingleHandlerServiceLocatorRouter::class)
        ->arg('$container', new Reference('sourcekin.command_handlers'))
        ->alias('sourcekin.command_router', 'sourcekin.command_bus.router.single_handler_locator')

        // snapshot
        ->set(SnapshotStore::class, PdoSnapshotStore::class)
        // projection manager
        ->set(ProjectionManager::class, MySqlProjectionManager::class)
    ;


};