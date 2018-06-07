<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 06.06.18
 *
 */

namespace Sourcekin\Domain\Message;

class MessageBus implements MessageBusInterface
{
    protected $bus;

    /**
     * @param object $message
     */
    public function dispatch($message){

    }
}