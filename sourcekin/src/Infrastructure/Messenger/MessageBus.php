<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 06.06.18
 *
 */

namespace Sourcekin\Infrastructure\Messenger;

use Sourcekin\Domain\Message\MessageBusInterface;
use Symfony\Component\Messenger\MessageBusInterface as MessengerBus;

class MessageBus implements MessageBusInterface
{

    /**
     * @var MessengerBus
     */
    protected $bus;

    /**
     * MessageBus constructor.
     *
     * @param MessengerBus $bus
     */
    public function __construct(MessengerBus $bus) { $this->bus = $bus; }


    /**
     * @param object $message
     *
     * @return mixed
     */
    public function dispatch($message)
    {
        return $this->bus->dispatch($message);

    }
}