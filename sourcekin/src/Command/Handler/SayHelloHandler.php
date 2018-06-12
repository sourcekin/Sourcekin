<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin\Command\Handler;


use Sourcekin\Command\SayHello;
use Sourcekin\Event\SaidHello;
use Sourcekin\EventHandling\EventRecorder;

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