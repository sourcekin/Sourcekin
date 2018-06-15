<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin\Command\Handler;


use Sourcekin\Command\SayHello;
use Sourcekin\Event\SaidHello;
use Sourcekin\EventDispatcher\Dispatcher;

class SayHelloHandler {

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * SayHelloHandler constructor.
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher) { $this->dispatcher = $dispatcher; }

    public function __invoke(SayHello $hello) {
        $this->dispatcher->trigger('said_hello', new SaidHello($hello->name()));
    }

}