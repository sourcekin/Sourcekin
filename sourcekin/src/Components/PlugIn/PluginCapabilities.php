<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Plugin;

use Sourcekin\Components\Events\EventEmitter;
use Sourcekin\Components\Events\ListenerHandler;
use Sourcekin\Components\Events\SourcekinEventEmitter;

trait PluginCapabilities
{
    /**
     * @var EventEmitter
     */
    protected $events;

    protected function events()
    {
        if( ! $this->events ) $this->events = new SourcekinEventEmitter();
        return $this->events;
    }

    public function attach(string $eventName, callable $listener, int $priority = 0): ListenerHandler
    {
        return $this->events()->attach($eventName, $listener, $priority);
    }

    public function detach(ListenerHandler $handler): void
    {
        $this->events()->detach($handler);
    }
}