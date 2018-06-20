<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 20.06.18.
 */

namespace SourcekinBundle\Factory;


use Prooph\Common\Event\ActionEventEmitter;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\EventStore;
use Prooph\EventStoreBusBridge\EventPublisher;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\Plugin\Router\MessageBusRouterPlugin;

class EventStoreFactory {
    public function decorate(
        EventStore $eventStore,
        ActionEventEmitter $emitter,
        EventBus $eventBus,
        MessageBusRouterPlugin $router
    ) {
        $emitterStore = new ActionEventEmitterEventStore($eventStore, $emitter);
        $publisher    = new EventPublisher($eventBus);
        $publisher->attachToEventStore($emitterStore);
        $router->attachToMessageBus($eventBus);

        return $emitterStore;

    }
}