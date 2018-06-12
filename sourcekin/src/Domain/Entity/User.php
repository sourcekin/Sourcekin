<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Entity;

use Sourcekin\Domain\Command\RegisterUser;
use Sourcekin\Domain\Message\EventRecorder;

abstract class User
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $email;

    /**
     * User constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     */
    public function __construct(string $username, string $password, string $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
    }

    public function username()
    {
        return $this->username;
    }

    public function password()
    {
        return $this->password;
    }

    public function email()
    {
        return $this->email;
    }


}