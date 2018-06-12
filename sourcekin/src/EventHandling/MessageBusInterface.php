<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin\EventHandling;


interface MessageBusInterface {

    /**
     * @param object $message
     *
     * @return mixed
     */
    public function dispatch($message);
}