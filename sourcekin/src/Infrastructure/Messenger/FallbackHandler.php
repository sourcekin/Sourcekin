<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Infrastructure\Messenger;

use Sourcekin\Domain\Message\MessageBusInterface;

class FallbackHandler
{
    /**
     * @var MessageBusInterface
     */
    protected $bus;

    /**
     * FallbackHandler constructor.
     *
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus = null) { $this->bus = $bus; }


    public function __invoke($message)
    {
        return null === $this->bus ? null : $this->bus->dispatch($message);
    }
}