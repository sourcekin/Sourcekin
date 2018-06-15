<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace SourcekinBundle\Broadway;


use Broadway\EventDispatcher\EventDispatcher;
use Sourcekin\EventDispatcher\Dispatcher;

class DispatcherAdapter implements Dispatcher {

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * DispatcherAdapter constructor.
     *
     * @param EventDispatcher $dispatcher
     */
    public function __construct(EventDispatcher $dispatcher) { $this->dispatcher = $dispatcher; }


    /**
     * @param string $eventName
     * @param array  $arguments
     */
    public function trigger(string $eventName, ...$arguments) {
        $this->dispatcher->dispatch($eventName, $arguments);
    }

    /**
     * @param string   $eventName
     * @param callable $callable
     */
    public function listenTo(string $eventName, callable $callable) {
        $this->dispatcher->addListener($eventName, $callable);
    }
}