<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Model\Command;


use Sourcekin\User\Model\UserRepository;

class ChangeEmailHandler {
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

    public function __invoke(ChangeEmail $command) {
        $user = $this->repository->get($command->id());
        $user->changeEmail($command->email());
        $this->repository->save($user);
    }
}