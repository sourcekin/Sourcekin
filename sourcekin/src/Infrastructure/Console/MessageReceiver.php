<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Infrastructure\Console;

use Sourcekin\Domain\Message\MessageReceivingInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class MessageReceiver
{
    /** @var MessageReceivingInterface|null */
    private $receiver;

    public function receive($message): void
    {
        if (null === $this->receiver) {
            return;
        }

        $this->receiver->onMessageReceived($message);
    }

    public function onCommand(ConsoleCommandEvent $event): void
    {
        $this->receiver = ($command = $event->getCommand()) instanceof MessageReceivingInterface ? $command : null;
    }

    public function onTerminate(): void
    {
        $this->receiver = null;
    }
}