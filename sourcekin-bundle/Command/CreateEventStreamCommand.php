<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 18.06.18
 *
 */

namespace SourcekinBundle\Command;

use PDO;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateEventStreamCommand extends Command
{
    /**
     * @var EventStore
     */
    private $eventStore;


    /**
     * CreateEventStreamCommand constructor.
     *
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore) {

        $this->eventStore = $eventStore;
        parent::__construct();

    }

    protected function configure()
    {
        $this
            ->setName('event-store:event-stream:create')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->eventStore->create(new Stream(new StreamName('event_stream'), new \ArrayIterator([])));
        $io->success(sprintf('Event stream "event_stream" created.'));
    }


}