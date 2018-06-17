<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Projection;


use Doctrine\DBAL\Connection;
use Sourcekin\User\Model\Event\EmailChanged;
use Sourcekin\User\Model\Event\UserRegistered;

class UserProjector {

    /**
     * @var Connection
     */
    private $connection;

    /**
     * UserProjector constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    /**
     * @param UserRegistered $event
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function onUserRegistered(UserRegistered $event) {
        $this->connection->insert(
            'read_user',
            [
                'email'    => $event->email(),
                'password' => $event->password(),
                'username' => $event->username(),
                'id'       => $event->aggregateId(),
            ]
        );
    }

    /**
     * @param EmailChanged $event
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function onEmailChanged(EmailChanged $event) {
        $this->connection->update(
            'read_user',
            ['email' => $event->email()],
            ['id' => $event->aggregateId()]
        );
    }


}