<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\User\Event;

use Broadway\Serializer\Serializable;

class UserSignedUp implements Serializable
{


    protected $id;

    protected $username;

    protected $email;

    protected $password;

    protected   $firstName;

    protected   $lastName;

    /**
     * UserSignedUp constructor.
     *
     * @param $id
     * @param $username
     * @param $email
     * @param $password
     * @param $firstName
     * @param $lastName
     */
    public function __construct($id, $username, $email, $password, $firstName, $lastName)
    {
        $this->id       = $id;
        $this->username = $username;
        $this->email    = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }



    public static function deserialize(array $data)
    {
        $data = (object)$data;
        return new static($data->id, $data->username, $data->email, $data->password, $data->firstName, $data->lastName);
    }

    public function serialize(): array
    {
        return [
            'id'        => $this->id,
            'username'  => $this->username,
            'password'  => $this->password,
            'email'     => $this->email,
            'firstName' => $this->firstName,
            'lastName'  => $this->lastName,
        ];
    }


}