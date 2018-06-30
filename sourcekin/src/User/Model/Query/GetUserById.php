<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 30.06.18
 *
 */

namespace Sourcekin\User\Model\Query;

class GetUserById
{
    protected $userId;

    /**
     * GetUserById constructor.
     *
     * @param $userId
     */
    public function __construct($userId) { $this->userId = $userId; }

    /**
     * @return mixed
     */
    public function userId()
    {
        return $this->userId;
    }



}