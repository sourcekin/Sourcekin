<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace Sourcekin\Domain\Message;

class Bus implements BusInterface
{
    /**
     * @var BusInterface
     */
    protected $messageBus;

    /**
     * @var BusInterface
     */
    protected $eventBus;

    /**
     * @var string[]
     */
    protected $eventClasses;

    /**
     * Bus constructor.
     *
     * @param BusInterface $messageBus
     * @param BusInterface $eventBus
     * @param string[]     $eventClasses
     */
    public function __construct(BusInterface $messageBus, BusInterface $eventBus, array $eventClasses = [])
    {
        $this->messageBus   = $messageBus;
        $this->eventBus     = $eventBus;
        $this->eventClasses = $eventClasses;
    }

    /**
     * @param $message
     *
     * @return mixed
     * @throws \Exception
     */
    public function dispatch($message)
    {
        $this->verifyMessage($message);

        if ($this->isEvent($message)) {
            return $this->eventBus->dispatch($message);
        }

        return $this->messageBus->dispatch($message);
    }

    /**
     * @param $message
     *
     * @throws \Exception
     */
    protected function verifyMessage($message): void
    {
        if (!is_object($message)) {
            throw new \Exception("expected object got '%s'", gettype($message));
        }
    }

    /**
     * @param $message
     *
     * @return bool
     */
    protected function isEvent($message): bool
    {
        return in_array(get_class($message), $this->eventClasses);
    }

}