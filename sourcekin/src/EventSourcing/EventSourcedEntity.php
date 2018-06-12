<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 12.06.18.
 */

namespace Sourcekin\EventSourcing;


use Sourcekin\Exception\AggregateRootAlreadyRegistered;

class EventSourcedEntity implements EventSourcedEntityInterface
{
    /**
     * @var EventSourcedAggregateRoot|null
     */
    private $aggregateRoot;

    /**
     * {@inheritdoc}
     */
    public function handleRecursively($event)
    {
        $this->handle($event);

        foreach ($this->getChildEntities() as $entity) {
            $entity->registerAggregateRoot($this->aggregateRoot);
            $entity->handleRecursively($event);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function registerAggregateRoot(EventSourcedAggregateRoot $aggregateRoot)
    {
        if (null !== $this->aggregateRoot && $this->aggregateRoot !== $aggregateRoot) {
            throw new AggregateRootAlreadyRegistered();
        }

        $this->aggregateRoot = $aggregateRoot;
    }

    protected function apply($event)
    {
        $this->aggregateRoot->apply($event);
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
     * Returns all child entities.
     *
     * @return EventSourcedEntity[]
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
}