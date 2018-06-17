<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace SourcekinBundle\Security;

use Doctrine\ORM\EntityRepository;
use SourcekinBundle\ReadModel\User\SecurityUser;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * UserProvider constructor.
     *
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository) {
        $this->repository = $repository;
    }


    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        if( null === ($user = $this->repository->findOneBy(['username' => $username]))){
            throw new UsernameNotFoundException();
        }
        return $user;
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     */
    public function refreshUser(UserInterface $user)
    {
        if( ! $user instanceof SecurityUser) throw new UnsupportedUserException();
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class instanceof SecurityUser;
    }
}