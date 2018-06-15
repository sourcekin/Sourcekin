<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace SourcekinBundle\Broadway;


use Broadway\CommandHandling\CommandBus as BroadwayCommandBus;
use Sourcekin\CommandHandling\CommandBus;

class CommandBusAdapter implements CommandBus {
    /** @var BroadwayCommandBus */
    protected $bus;

    /**
     * CommandBusAdapter constructor.
     *
     * @param BroadwayCommandBus $bus
     */
    public function __construct(BroadwayCommandBus $bus) { $this->bus = $bus; }


    /**
     * @param object $message
     *
     * @return mixed
     */
    public function execute($message) {
        return $this->bus->dispatch($message);
    }
}