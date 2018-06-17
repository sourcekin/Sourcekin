<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace SourcekinBundle\ReadModel\User;

use Sourcekin\User\ReadModel\LoginUser;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser extends LoginUser implements UserInterface
{

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    public function getSalt()
    {
        return null;
    }


}