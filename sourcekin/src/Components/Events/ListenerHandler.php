<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Events;

interface ListenerHandler {
    /**
     * @return callable
     */
    public function getEventListener(): callable;

    public function priority() : int;
}