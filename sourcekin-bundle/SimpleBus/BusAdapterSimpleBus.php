<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 10.06.18
 *
 */

namespace SourcekinBundle\SimpleBus;

use SimpleBus\Message\Bus\MessageBus;
use Sourcekin\Domain\Message\MessageBusInterface;

class BusAdapterSimpleBus implements MessageBusInterface
{

    /**
     * @var MessageBus
     */
    protected $messageBus;

    /**
     * BusAdapterSimpleBus constructor.
     *
     * @param MessageBus $messageBus
     */
    public function __construct(MessageBus $messageBus) { $this->messageBus = $messageBus; }


    /**
     * @param object $message
     *
     * @return mixed
     */
    public function dispatch($message)
    {
        return $this->messageBus->handle($message);
    }
}