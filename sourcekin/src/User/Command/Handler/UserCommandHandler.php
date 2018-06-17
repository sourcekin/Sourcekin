<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\User\Command\Handler;


use Broadway\CommandHandling\SimpleCommandHandler;
use Sourcekin\Components\PasswordEncoder;
use Sourcekin\User\Command\Enable;
use Sourcekin\User\Command\SignUp;
use Sourcekin\User\EventSourcing\UserRepository;
use Sourcekin\User\User;

class UserCommandHandler extends SimpleCommandHandler {

    /**
     * @var \Sourcekin\User\EventSourcing\UserRepository
     */
    protected $repository;

    /**
     * @var PasswordEncoder
     */
    protected $passwordEncoder;

    /**
     * UserCommandHandler constructor.
     *
     * @param \Sourcekin\User\EventSourcing\UserRepository $repository
     * @param PasswordEncoder                              $passwordEncoder
     */
    public function __construct(UserRepository $repository, PasswordEncoder $passwordEncoder) {
        $this->repository      = $repository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function handleSignUp(SignUp $command) {

        $user = User::signUp(
            $command->getId(),
            $command->getUsername(),
            $command->getEmail(),
            $this->passwordEncoder->encode($command->getPassword()),
            $command->getFirstName(),
            $command->getLastName()
        );

        $this->repository->save($user);
    }

    public function handleEnable(Enable $command)
    {
        $user = $this->lookUp($command->getId());
        $user->enable();
        $this->repository->save($user);

    }

    /**
     * @param $id
     *
     * @return \Broadway\Domain\AggregateRoot|User
     */
    protected function lookUp($id)
    {
        return $this->repository->load($id);
    }

}