<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace SourcekinBundle\Broadway;


use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Sourcekin\EventHandling\EventBus;
use Broadway\EventHandling\EventBus as BroadwayEventBus;
use Sourcekin\EventHandling\EventListener;
use Sourcekin\EventHandling\EventStream;

class EventBusAdapter implements EventBus {

    /** @var BroadwayEventBus */
    protected $bus;

    /**
     * EventBusAdapter constructor.
     *
     * @param BroadwayEventBus $bus
     */
    public function __construct(BroadwayEventBus $bus) { $this->bus = $bus; }

    /**
     * @param object $message
     *
     * @return mixed
     */
    public function dispatch(EventStream $message) {
        return $this->bus->publish(new DomainEventStream($message->events()));
    }

    public function subscribe(EventListener $eventListener) {
        $this->bus->subscribe(new EventHandlerDecorator($eventListener));
    }


}