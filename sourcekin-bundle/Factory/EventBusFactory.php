<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\Factory;

use Prooph\Common\Event\ActionEventEmitter;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStoreBusBridge\EventPublisher;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\Plugin\Router\EventRouter;

class EventBusFactory
{
    public function compose(ActionEventEmitter $emitter, ActionEventEmitterEventStore $eventStore, EventRouter $router)
    {
        $eventBus  = new EventBus($emitter);
        $publisher = new EventPublisher($eventBus);
        $publisher->attachToEventStore($eventStore);
        $router->attachToMessageBus($eventBus);

        return $eventBus;
    }
}