<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace SourcekinBundle\Messenger;


use SourcekinBundle\Console\MessageReceiver;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class EventReceiver implements MessageBusInterface {
    /**
     * @var MessageReceiver
     */
    protected $receiver;
    /**
     * @var MessageBusInterface
     */
    protected $eventBus;

    /**
     * EventReceiver constructor.
     *
     * @param MessageReceiver     $receiver
     * @param MessageBusInterface $eventBus
     */
    public function __construct(MessageReceiver $receiver, MessageBusInterface $eventBus) {
        $this->receiver = $receiver;
        $this->eventBus = $eventBus;
    }

    public function dispatch($message) {
        $this->receiver->receive($message);
        return $this->eventBus->dispatch($message);
    }


}