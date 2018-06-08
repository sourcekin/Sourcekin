<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Infrastructure\Messenger;

use Sourcekin\Infrastructure\Console\MessageReceiver;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class ConsoleMessageReceiverBus implements MessageBusInterface
{
    /**
     * @var MessageReceiver
     */
    protected $receiver;

    /**
     * @var MessageBusInterface
     */
    protected $bus;

    /**
     * ConsoleMessageReceiverBus constructor.
     *
     * @param MessageReceiver     $receiver
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageReceiver $receiver, MessageBusInterface $bus)
    {
        $this->receiver = $receiver;
        $this->bus      = $bus;
    }


    /**
     * Dispatches the given message.
     *
     * The bus can return a value coming from handlers, but is not required to do so.
     *
     * @param object|Envelope $message The message or the message pre-wrapped in an envelope
     *
     * @return mixed
     */
    public function dispatch($message)
    {
        $this->receiver->receive($message);
        return $this->bus->dispatch($message);
    }
}