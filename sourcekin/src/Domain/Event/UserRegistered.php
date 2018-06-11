<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Event;

class UserRegistered
{
    protected $username;
    protected $email;

    /**
     * UserRegistered constructor.
     *
     * @param $username
     * @param $email
     */
    public function __construct($username, $email)
    {
        $this->username = $username;
        $this->email    = $email;
    }

    public function username()
    {
        return $this->username;
    }

    public function email()
    {
        return $this->email;
    }
}