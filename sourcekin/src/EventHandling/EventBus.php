<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin\EventHandling;


interface EventBus {

    /**
     * @param EventStream $stream
     * @return mixed
     */
    public function dispatch( EventStream $stream );

    public function subscribe(EventListener $eventListener);
}