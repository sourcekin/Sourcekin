<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 06.06.18
 *
 */

namespace Sourcekin\Domain\Command\Handler;

use Sourcekin\Domain\Command\SayHello;
use Sourcekin\Domain\Event\SaidHello;
use Sourcekin\Domain\Message\MessageBusInterface;

class SayHelloHandler
{
    /** @var MessageBusInterface */
    protected $bus;

    /**
     * SayHelloHandler constructor.
     *
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus) { $this->bus = $bus; }


    public function __invoke(SayHello $hello)
    {
        $this->bus->dispatch(new SaidHello());
    }

}