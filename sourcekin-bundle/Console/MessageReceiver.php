<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace SourcekinBundle\Console;


use Sourcekin\Domain\Message\MessageReceivingInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class MessageReceiver {

    /**
     * @var MessageReceivingInterface
     */
    protected $receiver;

    public function receive($message) {
        if( is_null($this->receiver)) return;
        $this->receiver->onMessageReceived($message);
    }

    public function onCommand(ConsoleCommandEvent $event) {
        $this->receiver = ($command = $event->getCommand()) instanceof MessageReceivingInterface ? $command : null;
    }

    public function onTerminate() {
        $this->receiver = null;
    }
}