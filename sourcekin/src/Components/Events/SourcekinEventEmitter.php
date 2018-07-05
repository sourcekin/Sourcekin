<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Events;


use SplPriorityQueue as EventQueue;

class SourcekinEventEmitter implements EventEmitter {

    /**
     * @var ListenerHandler
     */
    protected $events = [];

    /**
     * @param Event $event
     */
    public function dispatch(Event $event) {
        foreach ($this->getListeners($event) as $handler) {
            $callable = $handler->getEventListener();
            $callable($event);
            if ($event->isPropagationStopped()) {
                return;
            }
        }
    }

    public function attach($event, callable $listener, int $priority = 1): ListenerHandler {
        $handler                = new GenericListenerHandler($listener, $priority);
        $this->events[$event][] = $handler;

        return $handler;
    }

    public function detach(ListenerHandler $listener) {
        foreach ($this->events as $event => $prioritized) {
            $this->events[$event] = array_filter(
                $prioritized,
                function ($handler) use ($listener) {
                    return $handler !== $listener;
                }
            );
        }
    }

    /**
     * @param Event $event
     *
     * @return ListenerHandler[]|EventQueue
     */
    protected function getListeners(Event $event): iterable {
        /** @var ListenerHandler[] $listeners */
        $listeners = $this->events[$event->getName()] ?? [];
        $queue     = new EventQueue();
        foreach ($listeners as $listener) {
            $queue->insert($listener, $listener->priority());
        }

        return $queue;
    }
}