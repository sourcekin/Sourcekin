<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Infrastructure\Messenger;

use Sourcekin\Domain\Message\DomainBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DomainBus implements DomainBusInterface
{

    /**
     * @var MessageBusInterface
     */
    protected $bus;

    /**
     * DomainBus constructor.
     *
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus) { $this->bus = $bus; }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function dispatch($message)
    {
        return $this->bus->dispatch($message);
    }
}