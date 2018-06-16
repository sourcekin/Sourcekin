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

    /**
     * UserSignedUp constructor.
     *
     * @param $id
     * @param $username
     * @param $email
     * @param $password
     */
    public function __construct($id, $username, $email, $password)
    {
        $this->id       = $id;
        $this->username = $username;
        $this->email    = $email;
        $this->password = $password;
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


    public static function deserialize(array $data)
    {
        $data = (object)$data;
        return new static($data->id, $data->username, $data->email, $data->password);
    }

    public function serialize(): array
    {
        return [
            'id'       => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'email'    => $this->email,
        ];
    }


}