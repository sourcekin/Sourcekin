<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Command;

class RegisterUser
{
    public $username;
    public $password;
    public $email;

    /**
     * RegisterUser constructor.
     *
     * @param $username
     * @param $password
     * @param $email
     */
    public function __construct($username, $password, $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
    }


}