<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 10.06.18
 *
 */

namespace Sourcekin\EventHandling;

class CommandBus implements MessageBusInterface
{
    /**
     * @var MessageBusInterface
     */
    protected $messageBus;

    /**
     * CommandBus constructor.
     *
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus) { $this->messageBus = $messageBus; }


    /**
     * @param object $message
     *
     * @return mixed
     */
    public function dispatch($message)
    {
        return $this->messageBus->dispatch($message);
    }
}