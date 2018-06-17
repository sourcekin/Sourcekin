<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace SourcekinBundle\ReadModel\User;

use Sourcekin\User\ReadModel\ScreenUser;

class AnonymousUser extends ScreenUser
{


    /**
     * AnonymousUser constructor.
     */
    public function __construct()
    {
        $this->id        = '';
        $this->username  = 'anonymous';
        $this->firstName = '';
        $this->lastName  = '';
        $this->email     = '';

    }
}