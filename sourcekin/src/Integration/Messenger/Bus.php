<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace Sourcekin\Integration\Messenger;

use Sourcekin\Domain\Message\BusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class Bus implements BusInterface
{

    /**
     * @var MessageBusInterface
     */
    protected $bus;

    /**
     * Bus constructor.
     *
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus) { $this->bus = $bus; }


    /**
     * @param $message
     *
     * @return mixed
     * @throws \Exception
     */
    public function dispatch($message)
    {
        return $this->bus->dispatch($message);
    }
}