<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\User\Command\Handler;


use Broadway\CommandHandling\SimpleCommandHandler;
use Sourcekin\User\Command\Enable;
use Sourcekin\User\Command\SignUp;
use Sourcekin\User\User;
use Sourcekin\User\UserRepository;

class UserCommandHandler extends SimpleCommandHandler {

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserCommandHandler constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function handleSignUp(SignUp $command) {
        $user = User::signUp($command->getId(), $command->getUsername(), $command->getEmail(), $command->getPassword());
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