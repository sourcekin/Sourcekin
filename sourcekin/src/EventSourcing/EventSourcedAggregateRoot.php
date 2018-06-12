<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 12.06.18.
 */

namespace Sourcekin\EventSourcing;


use Sourcekin\Domain\AggregateRootInterface;
use Sourcekin\Domain\EventStream;
use Sourcekin\Domain\Message;
use Sourcekin\Domain\Metadata;

class EventSourcedAggregateRoot implements AggregateRootInterface
{
    /**
     * @var array
     */
    private $uncommittedEvents = [];
    private $playhead = -1; // 0-based playhead allows events[0] to contain playhead 0

    /**
     * Applies an event. The event is added to the AggregateRootInterface's list of uncommitted events.
     *
     * @param $event
     */
    public function apply($event)
    {
        $this->handleRecursively($event);

        ++$this->playhead;
        $this->uncommittedEvents[] = Message::recordNow(
            $this->getAggregateRootId(),
            $this->playhead,
            new Metadata([]),
            $event
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getUncommittedEvents(): EventStream
    {
        $stream = new EventStream($this->uncommittedEvents);

        $this->uncommittedEvents = [];

        return $stream;
    }

    /**
     * Initializes the aggregate using the given "history" of events.
     */
    public function initializeState(EventStream $stream)
    {
        foreach ($stream as $message) {
            ++$this->playhead;
            $this->handleRecursively($message->getPayload());
        }
    }

    /**
     * Handles event if capable.
     *
     * @param $event
     */
    protected function handle($event)
    {
        $method = $this->getApplyMethod($event);

        if (!method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    /**
     * {@inheritdoc}
     */
    protected function handleRecursively($event)
    {
        $this->handle($event);

        foreach ($this->getChildEntities() as $entity) {
            $entity->registerAggregateRoot($this);
            $entity->handleRecursively($event);
        }
    }

    /**
     * Returns all child entities.
     *
     * Override this method if your aggregate root contains child entities.
     *
     * @return EventSourcedEntityInterface[]
     */
    protected function getChildEntities(): array
    {
        return [];
    }

    private function getApplyMethod($event): string
    {
        $classParts = explode('\\', get_class($event));

        return 'apply'.end($classParts);
    }

    public function getPlayhead(): int
    {
        return $this->playhead;
    }

}