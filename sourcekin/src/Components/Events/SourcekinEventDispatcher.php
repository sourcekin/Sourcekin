<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Sourcekin\Components\Events;

use SplObjectStorage;
use SplPriorityQueue;

/**
 * Class SourcekinEventDispatcher
 */
class SourcekinEventDispatcher implements EventDispatcher, \Countable
{

    /**
     * @var SplObjectStorage|EventHandler[]
     */
    protected $handlers;

    /**
     * SourcekinEventDispatcher constructor.
     *
     * @param array $handlers
     */
    public function __construct(... $handlers)
    {
        $this->handlers = new SplObjectStorage();
        foreach ($handlers as $handler) $this->attach($handler);

    }


    /**
     * @param IEvent $event
     */
    public function broadcast(IEvent $event)
    {
        $this->execute($event, $this->enqueue($event));
    }

    /**
     * @param EventHandler $handler
     */
    public function attach(EventHandler $handler)
    {
        $this->handlers->attach($handler);
    }

    /**
     * @param EventHandler $handler
     *
     * @return bool
     */
    public function contains(EventHandler $handler)
    {
        return $this->handlers->contains($handler);
    }

    /**
     * @param $handler
     */
    public function detach($handler)
    {
        $this->handlers->detach($handler);
    }

    /** @inheritdoc */
    public function count()
    {
        return count($this->handlers);
    }

    /**
     * @param IEvent           $event
     * @param SplPriorityQueue $queue
     */
    private function execute(IEvent $event, SplPriorityQueue $queue)
    {
        while ($queue->valid()) {
            $queue->extract()->handle($event);
        }
    }

    /**
     * @param IEvent $event
     *
     * @return SplPriorityQueue
     */
    private function enqueue(IEvent $event)
    {
        $queue = new SplPriorityQueue();

        foreach ($this->handlers as $handler) {
            if ($handler->supports($event)) {
                $queue->insert($handler, $handler->priority());
            }
        }

        return $queue;
    }
}