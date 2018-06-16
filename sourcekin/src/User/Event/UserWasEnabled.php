<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

namespace Sourcekin\User\Event;

use Broadway\Serializer\Serializable;

class UserWasEnabled implements Serializable
{
    protected $id;

    /**
     * UserWasEnabled constructor.
     *
     * @param $id
     */
    public function __construct($id) { $this->id = $id; }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        $obj = new static();
        $obj->id = $data['id'];
        return $obj;
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return ['id' => $this->id];
    }
}