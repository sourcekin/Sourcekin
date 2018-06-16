<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\User;


use Broadway\CommandHandling\SimpleCommandHandler;

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

    public function handleRegister(RegisterUser $command) {
        $user = User::register($command->getId(), $command->getUsername(), $command->getEmail(), $command->getPassword());
        $this->repository->save($user);
    }

}