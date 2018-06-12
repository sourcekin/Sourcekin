<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 12.06.18.
 */

namespace Sourcekin\EventSourcing;


use Sourcekin\Exception\AggregateRootAlreadyRegistered;

interface EventSourcedEntityInterface
{
    /**
     * Recursively handles $event.
     *
     * @param $event
     */
    public function handleRecursively($event);

    /**
     * Registers aggregateRoot as this EventSourcedEntityInterface's aggregate root.
     *
     * @param EventSourcedAggregateRoot $aggregateRoot
     *
     * @throws AggregateRootAlreadyRegistered
     */
    public function registerAggregateRoot(EventSourcedAggregateRoot $aggregateRoot);
}