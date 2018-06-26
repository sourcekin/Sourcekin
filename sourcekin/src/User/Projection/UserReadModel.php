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
use Prooph\EventStore\Projection\AbstractReadModel;

class UserReadModel extends AbstractReadModel
{

    const TABLE_NAME = 'users';

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * UserReadModel constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function delete(): void
    {
        $schema    = $this->connection->getSchemaManager()->createSchema();
        $newSchema = clone $schema;
        $newSchema->dropTable(static::TABLE_NAME);
        foreach ($schema->getMigrateToSql($newSchema, $this->connection->getDatabasePlatform()) as $item) {
            $this->connection->exec($item);
        };
    }

    public function init(): void
    {
        $schema   = $this->connection->getSchemaManager()->createSchema();
        $toSchema = clone $schema;
        $this->configureTable($toSchema->createTable(static::TABLE_NAME));

        foreach ($schema->getMigrateToSql($toSchema, $this->connection->getDatabasePlatform()) as $query) {
            $this->connection->exec($query);
        }

    }

    public function isInitialized(): bool
    {
        $schema = $this->connection->getSchemaManager()->createSchema();

        return $schema->hasTable(static::TABLE_NAME);
    }

    public function reset(): void
    {
        $this->connection->exec("truncate table ".static::TABLE_NAME);

    }

    public function insert($data)
    {
        $this->connection->insert(static::TABLE_NAME, $data);
    }

    public function changeEmail($data)
    {
        $this->connection->update(static::TABLE_NAME, ['email' => $data['email']], ['id' => $data['id']]);
    }

    protected function configureTable(Table $table)
    {
        $table->addColumn('id', 'string', ['length' => 36, 'notnull' => true]);
        $table->addColumn('username', 'string', ['notnull' => true]);
        $table->addColumn('email', 'string', ['notnull' => true]);
        $table->addColumn('password', 'string', ['notnull' => true]);

        return $table;
    }
}