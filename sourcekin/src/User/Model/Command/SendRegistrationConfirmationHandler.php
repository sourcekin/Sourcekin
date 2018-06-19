<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 19.06.18.
 */

namespace Sourcekin\User\Model\Command;


use Prooph\ServiceBus\QueryBus;
use Sourcekin\User\Projection\UserFinder;
use Symfony\Component\Messenger\Transport\TransportInterface;

class SendRegistrationConfirmationHandler {

    /**
     * @var UserFinder
     */
    protected $finder;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;



    public function __invoke(SendRegistrationConfirmation $command) {
        $user = $this->finder->findById($command->id());

    }

}