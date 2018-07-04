<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Sourcekin\Components\Events;

interface EventDispatcher
{
    public function broadcast(IEvent $event);
}