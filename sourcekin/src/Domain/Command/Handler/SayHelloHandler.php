<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin\Domain\Command\Handler;


use Sourcekin\Domain\Command\SayHello;
use Sourcekin\Domain\Event\SaidHello;
use Sourcekin\Domain\Message\EventBus;
use Sourcekin\Domain\Message\MessageBusInterface;

class SayHelloHandler {

    /**
     * @var MessageBusInterface
     */
    protected $eventBus;

    /**
     * SayHelloHandler constructor.
     *
     * @param EventBus $eventBus
     */
    public function __construct(EventBus $eventBus) {
        $this->eventBus = $eventBus;
    }

    public function __invoke(SayHello $hello) {
        $this->eventBus->dispatch(new SaidHello());
    }
}