<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

namespace SourcekinBundle\Command;

use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Comparator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitEventStoreCommand extends Command
{
    /**
     * @var DBALEventStore
     */
    protected $store;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * InitEventStoreCommand constructor.
     *
     * @param DBALEventStore $store
     */
    public function __construct(DBALEventStore $store, Connection $connection)
    {
        $this->store      = $store;
        $this->connection = $connection;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('sourcekin:init:dbal-event-store');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io     = new SymfonyStyle($input, $output);


        $fromSchema = $this->connection->getSchemaManager()->createSchema();
        $toSchema   = clone $fromSchema;

        if( null ===  ($table = $this->store->configureSchema($toSchema))) {
            $io->note('The event store table is already defined.');
            return 0;
        }
        $this->connection->beginTransaction();
        try {

            $sql = (new Comparator())->compare($fromSchema, $toSchema)->toSql($this->connection->getDatabasePlatform());
            while($query = array_shift($sql)) $this->connection->exec($query);

            $io->success('dbal event store table created.');
            $this->connection->commit();
        } catch(\Exception $e) {
            $io->error('No bueno');
            $io->writeln($e->getMessage());
            $this->connection->rollBack();
        }

    }


}