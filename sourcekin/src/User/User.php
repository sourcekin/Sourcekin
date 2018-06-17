<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\User;


use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Sourcekin\User\Event\UserSignedUp;
use Sourcekin\User\Event\UserWasEnabled;

class User extends EventSourcedAggregateRoot {

    private $id;

    private $username;

    private $email;

    private $password;

    /**
     * @var bool
     */
    private $enabled = false;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @return string
     */
    public function getAggregateRootId(): string {
        return $this->id;
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

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }


    public static function signUp($id, $username, $email, $password, $firstName, $lastName) {
        $user = new static();
        $user->apply(new UserSignedUp($id, $username, $email, $password, $firstName, $lastName));
        return $user;
    }

    public function enable()
    {
        if( $this->isEnabled()) return;
        $this->apply(new UserWasEnabled($this->id));
    }

    public function applyUserSignedUp(UserSignedUp $event) {

        $this->id       = $event->getId();
        $this->username = $event->getUsername();
        $this->email    = $event->getEmail();
        $this->password = $event->getPassword();

    }

    public function applyUserWasEnabled(UserWasEnabled $enabled)
    {
        if( $enabled->getId() === $this->getId()) {
            $this->enabled = $enabled;
        }
    }
}