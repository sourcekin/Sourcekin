<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Model\Command;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

class RegisterUser extends Command {
    use PayloadTrait;

    public function id() : string {
        return $this->payload()['id'];
    }

    public function username() : string {
        return $this->payload()['username'];
    }
    public function email() : string {
        return $this->payload()['email'];
    }

    public function password() : string {
        return $this->payload()['password'];
    }
}