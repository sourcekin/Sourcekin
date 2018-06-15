<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\EventDispatcher;


interface Dispatcher {
    /**
     * @param string $eventName
     * @param array  $arguments
     */
    public function trigger(string $eventName, ...$arguments);

    /**
     * @param string   $eventName
     * @param callable $callable
     */
    public function listenTo(string $eventName, callable $callable);
}