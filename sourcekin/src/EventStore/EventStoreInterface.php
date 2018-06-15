<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 14.06.18
 *
 */

namespace Sourcekin\EventStore;

use Sourcekin\Domain\EventStream;
use Sourcekin\Exception\DuplicatePlayhead;

interface EventStoreInterface
{
    /**
     * @param mixed $id
     *
     * @return EventStream
     */
    public function load($id): EventStream;

    /**
     * @param mixed $id
     * @param int   $playhead
     *
     * @return EventStream
     */
    public function loadFromPlayhead($id, int $playhed): EventStream;

    /**
     * @param mixed             $id
     * @param EventStream $eventStream
     *
     * @throws DuplicatePlayhead
     */
    public function append($id, EventStream $eventStream);
}