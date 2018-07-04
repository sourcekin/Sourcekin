<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Sourcekin\Components\Events;

trait BroadcastCapabilities
{
    /**
     * @var SourcekinEventDispatcher
     */
    protected $dispatcher;

    /**
     * @param Messenger $messenger
     */
    protected function broadcast(Messenger $messenger)
    {
        foreach ($messenger->events() as $event) $this->dispatcher->broadcast($event);

        $messenger->clearEvents();
    }

}