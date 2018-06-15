<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace SourcekinBundle\Broadway;


use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener as BroadwayListener;
use Sourcekin\EventHandling\EventListener;

class EventHandlerDecorator implements BroadwayListener {
    /**
     * @var EventListener
     */
    protected $listener;

    /**
     * EventHandlerDecorator constructor.
     *
     * @param EventListener $listener
     */
    public function __construct(EventListener $listener) { $this->listener = $listener; }


    public function handle(DomainMessage $domainMessage) {

        $this->listener->handle($domainMessage->getPayload());

    }


}