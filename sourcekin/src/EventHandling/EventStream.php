<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\EventHandling;


class EventStream {
    protected $events = [];

    /**
     * EventStream constructor.
     *
     * @param array $events
     */
    public function __construct(array $events = []) {
        $this->events = $events;
    }

    public function events() {
        return $this->events;
    }
}