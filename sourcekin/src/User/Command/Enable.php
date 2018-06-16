<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

namespace Sourcekin\User\Command;

class Enable
{
    protected $id;

    /**
     * Enable constructor.
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



}