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
use Sourcekin\Domain\Event\UserRegistered;
use Sourcekin\Domain\Factory\DomainObjectFactory;
use Sourcekin\Domain\Message\EventRecorder;
use Sourcekin\Domain\Persistence\ObjectStore;

class RegisterUserHandler
{
    /**
     * @var EventRecorder
     */
    protected $recorder;

    /**
     * @var DomainObjectFactory
     */
    private $factory;

    /**
     * @var ObjectStore
     */
    private $store;

    /**
     * RegisterUserHandler constructor.
     *
     * @param EventRecorder       $recorder
     * @param DomainObjectFactory $factory
     * @param ObjectStore         $store
     */
    public function __construct(EventRecorder $recorder, DomainObjectFactory $factory, ObjectStore $store) {
        $this->recorder = $recorder;
        $this->factory = $factory;
        $this->store = $store;
    }


    public function __invoke(RegisterUser $command)
    {
        /** @var User $user */
        $user = $this->factory->make(User::class, (array)$command);
        $this->store->store($user);
        $this->recorder->record(new UserRegistered($user->username(), $user->email()));
    }
}