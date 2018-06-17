<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace Sourcekin\User\ReadModel;

use Broadway\ReadModel\Identifiable;
use Broadway\Serializer\Serializable;
use Sourcekin\User\Event\UserSignedUp;

class ScreenUser implements Identifiable, Serializable
{

    protected $id;

    protected $username;

    protected $email;

    protected $firstName;

    protected $lastName;

    /**
     * ScreenUser constructor.
     *
     * @param $id
     */
    public function __construct($id) { $this->id = $id; }

    /**
     * @return string
     */
    public function getId(): string
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

    public function applySignedUp(UserSignedUp $signedUp)
    {
        $this->firstName = $signedUp->getFirstName();
        $this->lastName  = $signedUp->getLastName();
        $this->email     = $signedUp->getEmail();
        $this->username  = $signedUp->getUsername();
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        $data            = (object)$data;
        $user            = new static($data->id);
        $user->username  = $data->username;
        $user->email     = $data->email;
        $user->firstName = $data->firstName;
        $user->lastName  = $data->lastName;
        return $user;
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return get_object_vars($this);
    }
}