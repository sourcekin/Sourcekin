<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\Factory;

use Prooph\Common\Event\ActionEventEmitter;
use Sourcekin\Components\ServiceBus\EventBus;

class EventBusFactory
{
    public function compose(ActionEventEmitter $emitter)
    {
        $eventBus = new EventBus($emitter);

        return $eventBus;
    }
}