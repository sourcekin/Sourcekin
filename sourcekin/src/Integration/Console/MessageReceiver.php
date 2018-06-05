<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace Sourcekin\Integration\Console;

use Sourcekin\Domain\Message\MessageReceiverInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class MessageReceiver
{
    /**
     * @var MessageReceiverInterface
     */
    protected $receiver;

    public function receive($message) {
        if( ! $this->receiver ) return;
        $this->receiver->onMessageReceived($message);
    }

    public function onCommand(ConsoleCommandEvent $event)
    {
        $this->receiver = ($command = $event->getCommand()) instanceof MessageReceiverInterface ? $command : null;
    }

    public function onTerminate()
    {
        $this->receiver = null;
    }

}