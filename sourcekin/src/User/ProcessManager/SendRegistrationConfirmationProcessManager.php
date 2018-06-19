<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 19.06.18.
 */

namespace Sourcekin\User\ProcessManager;


use Prooph\ServiceBus\CommandBus;
use Sourcekin\User\Model\Command\SendRegistrationConfirmation;
use Sourcekin\User\Model\Event\UserRegistered;

class SendRegistrationConfirmationProcessManager {
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * SendRegistrationConfirmationProcessManager constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus) { $this->commandBus = $commandBus; }


    public function __invoke(UserRegistered $event) {

        $this->commandBus->dispatch(SendRegistrationConfirmation::withUserId($event->aggregateId()));
    }
}