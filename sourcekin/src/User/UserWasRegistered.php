<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\User;


class UserWasRegistered {
    protected $id;
    protected $username;
    protected $email;
    protected $password;

    /**
     * UserWasRegistered constructor.
     *
     * @param $id
     * @param $username
     * @param $email
     * @param $password
     */
    public function __construct($id, $username, $email, $password) {
        $this->id       = $id;
        $this->username = $username;
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

}