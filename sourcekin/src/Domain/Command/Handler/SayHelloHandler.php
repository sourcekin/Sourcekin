<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Domain\Command\Handler;

use Sourcekin\Domain\Command\SayHello;
use Sourcekin\Domain\Event\SaidHello;
use Sourcekin\Domain\Message\DomainBusInterface;

class SayHelloHandler
{
    /**
     * @var DomainBusInterface
     */
    protected $bus;

    /**
     * SayHelloHandler constructor.
     *
     * @param DomainBusInterface $bus
     */
    public function __construct(DomainBusInterface $bus) { $this->bus = $bus; }


    public function __invoke(SayHello $command)
    {
        $this->bus->dispatch(new SaidHello());
    }
}