<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 12.06.18.
 */

namespace Sourcekin\Domain;


use IteratorAggregate;
use Traversable;

class EventStream implements IteratorAggregate {
    protected $events = [];

    /**
     * EventStream constructor.
     *
     * @param array $events
     */
    public function __construct(array $events) { $this->events = $events; }


    /**
     * Retrieve an external iterator
     *
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator() {
        return new \ArrayIterator($this->events);
}}