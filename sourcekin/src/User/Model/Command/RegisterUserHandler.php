<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Model\Command;


use Sourcekin\User\Model\User;
use Sourcekin\User\Model\UserRepository;

class RegisterUserHandler {
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * RegisterUserHandler constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository) { $this->repository = $repository; }

    public function __invoke(RegisterUser $command) {
        $user = User::registerWithData($command->id(), $command->email(), $command->username(), $command->password());
        $this->repository->save($user);
    }


}