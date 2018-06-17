<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Model\Event;


use Prooph\EventSourcing\AggregateChanged;

class UserRegistered extends AggregateChanged {

    public function username() {
        return $this->payload['username'];
    }

    public function email() {
        return $this->payload['email'];
    }

    public function password() {
        return $this->payload['password'];
    }
}