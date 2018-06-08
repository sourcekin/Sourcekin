<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Infrastructure\Messenger;

use Sourcekin\Domain\Message\DomainBusInterface;

class FallbackMessageHandler
{

    /**
     * @var DomainBusInterface
     */
    private $bus;

    /**
     * FallbackMessageHandler constructor.
     *
     * @param DomainBusInterface $bus
     */
    public function __construct(DomainBusInterface $bus = null) { $this->bus = $bus; }


    public function __invoke($message)
    {
        return null === $this->bus ? null : $this->bus->dispatch($message);
    }
}