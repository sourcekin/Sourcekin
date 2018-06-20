<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 19.06.18.
 */

namespace Sourcekin\User\Projection;


use Doctrine\DBAL\Connection;

class UserFinder {
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * UserFinder constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }


    public function findById($id) {
        $builder = $this->connection->createQueryBuilder();
        $user    = $builder
            ->select()
            ->from(UserReadModel::TABLE_NAME)
            ->where('id = ?')
            ->setParameter(0, $id)
            ->execute()
            ->fetch(\PDO::FETCH_OBJ)
        ;

        return $user;
    }


}