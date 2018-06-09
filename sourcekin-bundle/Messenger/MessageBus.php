<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace SourcekinBundle\Messenger;
use Sourcekin\Domain\Message\MessageBusInterface as DomainBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageBus implements DomainBusInterface {

    /**
     * @var MessageBusInterface
     */
    protected $bus;

    /**
     * MessageBus constructor.
     *
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus) { $this->bus = $bus; }

    /**
     * @param object $message
     *
     * @return mixed
     */
    public function dispatch($message) {
        return $this->bus->dispatch($message);
    }
}