<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

namespace Sourcekin\User\ReadModel;

use Broadway\ReadModel\Identifiable;
use Broadway\Serializer\Serializable;

class LoginUser implements Identifiable, Serializable
{
    protected $id;

    protected $username;

    protected $password;

    protected $enabled = false;

    /**
     * LoginUser constructor.
     *
     * @param $id
     */
    public function __construct($id) { $this->id = $id; }

    /**
     * @param $username
     * @param $password
     */
    public function assignCredentials($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function enable()
    {
        $this->enabled = true;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        $data            = (object)$data;
        $model           = new static($data->id);
        $model->username = $data->username;
        $model->password = $data->password;
        $model->enabled  = $data->enabled ?? false;

        return $model;
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'id'       => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'enabled'  => $this->enabled,
        ];
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }


}