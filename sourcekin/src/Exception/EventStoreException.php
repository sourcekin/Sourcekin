<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 14.06.18
 *
 */

namespace Sourcekin\Exception;

use Exception;
use Sourcekin\Domain\EventStream;

class EventStoreException extends \RuntimeException
{
    /**
     * @var EventStream
     */
    private $eventStream;

    /**
     * @param EventStream $eventStream
     * @param Exception         $previous
     */
    public function __construct(EventStream $eventStream, $previous = null)
    {
        parent::__construct('', 0, $previous);

        $this->eventStream = $eventStream;
    }

    /**
     * @return EventStream
     */
    public function getEventStream(): EventStream
    {
        return $this->eventStream;
    }
}