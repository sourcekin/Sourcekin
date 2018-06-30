<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 19.06.18
 *
 */

namespace SourcekinBundle\Command;

use Doctrine\DBAL\Connection;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Sourcekin\Components\SchemaFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallCommand extends Command
{
    /**
     * @var Connection
     */
    protected $dbalConnection;

    /**
     * @var array
     */
    protected $streams;

    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * InstallCommand constructor.
     *
     * @param Connection $dbalConnection
     * @param EventStore $eventStore
     * @param array      $streamNames
     */
    public function __construct(Connection $dbalConnection, EventStore $eventStore, array $streamNames)
    {
        $this->dbalConnection = $dbalConnection;
        $this->streams        = $streamNames;
        $this->eventStore = $eventStore;
        parent::__construct();
    }


    protected function configure()
    {
        $this->setName('sourcekin:install');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io            = new SymfonyStyle($input, $output);
        $currentSchema = $this->dbalConnection->getSchemaManager()->createSchema();
        $platform      = $this->dbalConnection->getDatabasePlatform();
        $queries       = 0;
        foreach ($currentSchema->getMigrateToSql(SchemaFactory::makeInstallationSchema(), $platform) as $query) {
            $this->dbalConnection->exec($query);
            $queries++;
            // $io->writeln($query);
        };
        $io->writeln(sprintf('Executed <info>%d</info> queries', ($queries)));

        foreach ($this->streams as $stream) {
            $io->writeln(sprintf('Checking stream <info>%s</info>',$stream));

            if( $this->eventStore->hasStream($streamName = new StreamName($stream))) {
                $this->eventStore->appendTo($streamName, new \ArrayIterator([]));
                continue;
            }

            $this->eventStore->create(new Stream(new StreamName($stream), new \ArrayIterator([])));
            $io->success($stream);
        }

    }


}