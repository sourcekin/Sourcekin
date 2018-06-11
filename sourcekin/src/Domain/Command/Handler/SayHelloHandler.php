<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin\Domain\Command\Handler;


use Sourcekin\Domain\Command\SayHello;
use Sourcekin\Domain\Event\SaidHello;
use Sourcekin\Domain\Message\EventBus;
use Sourcekin\Domain\Message\EventRecorder;
use Sourcekin\Domain\Message\MessageBusInterface;

class SayHelloHandler {


    /**
     * @var EventRecorder
     */
    private $recorder;

    /**
     * SayHelloHandler constructor.
     *
     * @param EventRecorder $recorder
     */
    public function __construct(EventRecorder $recorder) {
        $this->recorder = $recorder;
    }

    public function __invoke(SayHello $hello) {
        $this->recorder->record(new SaidHello($hello->name()));
    }
}