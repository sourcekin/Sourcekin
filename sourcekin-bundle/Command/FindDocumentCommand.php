<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 02.07.18
 *
 */

namespace SourcekinBundle\Command;

use Sourcekin\Components\ServiceBus\QueryBus;
use Sourcekin\Content\Model\Query\GetDocumentById;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FindDocumentCommand extends Command
{

    /**
     * @var QueryBus
     */
    protected $queryBus;

    /**
     * FindDocumentCommand constructor.
     *
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('sourcekin:find:document')->addArgument('document-id', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io      = new SymfonyStyle($input, $output);
        $promise = $this->queryBus->dispatch(new GetDocumentById($input->getArgument('document-id')));
        $promise->then(function($result) use ($io) {
            $io->writeln($result);
        });


    }


}