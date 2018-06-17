<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace SourcekinBundle\ReadModel\User;

use Broadway\ReadModel\Repository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ScreenUserProvider
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * ScreenUserProvider constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param Repository            $repository
     */
    public function __construct(TokenStorageInterface $tokenStorage, Repository $repository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->repository   = $repository;
    }

    public function currentUser()
    {
        if( ! ($token = $this->tokenStorage->getToken())) {
            return new AnonymousUser();
        }
        if( ! ($user = $token->getUser()) instanceof SecurityUser) {
            return new AnonymousUser();
        }

        return $this->repository->find($user->getId());
    }

}