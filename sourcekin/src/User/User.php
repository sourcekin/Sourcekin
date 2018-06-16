<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\User;


use Broadway\EventSourcing\EventSourcedAggregateRoot;

class User extends EventSourcedAggregateRoot {

    private $id;

    private $username;

    private $email;

    private $password;


    /**
     * @return string
     */
    public function getAggregateRootId(): string {
        return $this->id;
    }

    public static function register($id, $username, $email, $password) {
        $user = new static();
        $user->apply(new UserWasRegistered($id, $username, $email, $password));
        return $user;
    }

    public function applyUserWasRegistered(UserWasRegistered $event) {

        $this->id       = $event->getId();
        $this->username = $event->getUsername();
        $this->email    = $event->getEmail();
        $this->password = $event->getPassword();

    }
}