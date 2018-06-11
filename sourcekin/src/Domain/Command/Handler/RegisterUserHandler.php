<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Command\Handler;

use Sourcekin\Domain\Command\RegisterUser;
use Sourcekin\Domain\Entity\User;
use Sourcekin\Domain\Message\EventRecorder;

class RegisterUserHandler
{
    /**
     * @var EventRecorder
     */
    protected $recorder;

    /**
     * RegisterUserHandler constructor.
     *
     * @param EventRecorder $recorder
     */
    public function __construct(EventRecorder $recorder) { $this->recorder = $recorder; }


    public function __invoke(RegisterUser $command)
    {
        $user = User::fromCommand($command);

    }
}