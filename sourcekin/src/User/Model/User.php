<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Model;


use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Sourcekin\Components\ApplyEventCapabilities;
use Sourcekin\User\Model\Event\EmailChanged;
use Sourcekin\User\Model\Event\UserRegistered;

class User extends AggregateRoot {

    use ApplyEventCapabilities;

    private $id, $username, $email, $password;

    static public function registerWithData(string $email, string $username, string $password): self {
        $obj = new self;
        $obj
            ->recordThat(
                UserRegistered::occur(
                    Uuid::uuid4()->toString(),
                    [
                        'username' => $username,
                        'email'    => $email,
                        'password' => $password,
                    ]
                )
            );

        return $obj;
    }

    public function changeEmail($email) {
        if ($this->email === $email) {
            return;
        }

        $this->recordThat(
            EmailChanged::occur(
                $this->id,
                [
                    'email' => $email,
                ]
            )
        );
    }


    protected function aggregateId(): string {
        return $this->id;
    }

    protected function onUserRegistered(UserRegistered $event) {
        $this->id       = $event->aggregateId();
        $this->email    = $event->email();
        $this->password = $event->password();
        $this->username = $event->username();
    }

    protected function onEmailChanged(EmailChanged $event) {
        $this->id    = $event->aggregateId();
        $this->email = $event->email();
    }
}