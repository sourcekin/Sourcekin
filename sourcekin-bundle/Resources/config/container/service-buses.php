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
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Prooph\ServiceBus\Plugin\Router\SingleHandlerServiceLocatorRouter;
use Prooph\SnapshotStore\Pdo\PdoSnapshotStore;
use Prooph\SnapshotStore\SnapshotStore;
use Sourcekin\Application;
use Sourcekin\Components\ServiceBus\EventBus;
use Sourcekin\Components\ServiceBus\CommandBus;
use Sourcekin\Components\ServiceBus\QueryBus;
use SourcekinBundle\DependencyInjection\Dependencies;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

return function (ContainerConfigurator $container) {

    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()

        // service-locators
        ->set('sourcekin.projection.projectors', ServiceLocator::class)
        ->set('sourcekin.projection.read_models', ServiceLocator::class)

        // Aggregate translator
        ->set(AggregateTranslator::class, \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class)

        // command locator
        ->set('sourcekin.command_handlers', ServiceLocator::class)
        ->set('sourcekin.command_locator', \Prooph\ServiceBus\Plugin\ServiceLocatorPlugin::class)
        ->arg('$serviceLocator', new Reference('sourcekin.command_handlers'))
        ->tag('sourcekin.plugin', ['type' => Dependencies::TYPE_COMMAND_BUS])

        // query locator
        ->set('sourcekin.query_handlers', ServiceLocator::class)
        ->set('sourcekin.query_locator', \Prooph\ServiceBus\Plugin\ServiceLocatorPlugin::class)
        ->arg('$serviceLocator', new Reference('sourcekin.query_handlers'))
        ->tag('sourcekin.plugin', ['type' => Dependencies::TYPE_QUERY_BUS])

        // event locator
        ->set('sourcekin.event_handlers', ServiceLocator::class)
        ->set('sourcekin.event_locator', \Prooph\ServiceBus\Plugin\ServiceLocatorPlugin::class)
        ->arg('$serviceLocator', new Reference('sourcekin.event_handlers'))
        ->tag('sourcekin.plugin', ['type' => Dependencies::TYPE_EVENT_BUS])


        // inner event store
        ->set(MessageFactory::class, FQCNMessageFactory::class)
        ->set(PersistenceStrategy::class, PersistenceStrategy\MySqlSingleStreamStrategy::class)
        ->set(MySqlEventStore::class)
        ->tag('sourcekin.dependency', ['alias' => Dependencies::EVENT_STORE])


        ->set(EventStore::class)->factory([new Reference(Application::class), 'getEventStore'])
        ->set(EventBus::class)->factory([new Reference(Application::class), 'getEventBus'])
        ->set(CommandBus::class)->factory([new Reference(Application::class), 'getCommandBus'])
        ->set(QueryBus::class)->factory([new Reference(Application::class), 'getQueryBus'])

        // snapshot
        ->set(SnapshotStore::class, PdoSnapshotStore::class)
        // projection manager
        ->set(ProjectionManager::class, MySqlProjectionManager::class)

    ;


};