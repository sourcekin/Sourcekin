<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 18.06.18
 *
 */

namespace Sourcekin\User\Projection;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;
use Prooph\EventStore\Projection\AbstractReadModel;

class UserReadModel extends AbstractReadModel
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * UserReadModel constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }


    public function init(): void
    {
        $schema = $this->connection->getSchemaManager()->createSchema();
        $toSchema = clone $schema;
        $this->configureTable($toSchema->createTable('read_users'));


        foreach($schema->getMigrateToSql($toSchema, $this->connection->getDatabasePlatform()) as $query) {
            $this->connection->exec($query);
        }

    }

    protected function configureTable(Table $table)
    {
        $table->addColumn('id', 'string', ['length' => 36, 'notnull' => true] );
        $table->addColumn('username', 'string', ['notnull' => true]);
        $table->addColumn('email', 'string' , ['notnull' => true]);
        $table->addColumn('password', 'string', ['notnull' => true]);
        return $table;
    }

    public function isInitialized(): bool
    {
        $schema = $this->connection->getSchemaManager()->createSchema();
        return $schema->hasTable('read_users');
    }

    public function reset(): void
    {
        $this->connection->exec("truncate table read_users;");

    }

    public function delete(): void
    {
        $schema = $this->connection->getSchemaManager()->createSchema();
        $newSchema = clone $schema;
        $newSchema->dropTable('read_users');
        foreach ($schema->getMigrateToSql($newSchema, $this->connection->getDatabasePlatform()) as $item) {
            $this->connection->exec($item);
        };
    }

    public function insert($data)
    {
        $this->connection->insert('read_users', $data);
    }
    public function changeEmail($data) {
        $this->connection->update('read_users', ['email' => $data['email']], ['id' => $data['id']]);
    }
}