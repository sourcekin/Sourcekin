<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 18.06.18
 *
 */

namespace SourcekinBundle\Command;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SetupCommand extends Command
{
    /**
     * @var PDO
     */
    private $connection;

    private $vendorDir;


    /**
     * SetupCommand constructor.
     */
    public function __construct(PDO $connection, $vendorDir) {

        parent::__construct();
        $this->connection = $connection;
        $this->vendorDir = $vendorDir;
    }

    protected function configure()
    {
        $this->setName('event-store:setup')
            ->addOption('platform', null, InputOption::VALUE_REQUIRED, '', 'mariadb')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        foreach ( glob(sprintf('%s/prooph/pdo-event-store/scripts/%s/*.sql', $this->vendorDir, $input->getOption('platform'))) as $filename) {
            $io->writeln("executing <info>$filename</info>");
            $queries  = array_filter(array_map('trim',explode(';', file_get_contents($filename))));
            foreach ($queries as $query) {
                $this->connection->exec($query);
            }
        }
    }


}