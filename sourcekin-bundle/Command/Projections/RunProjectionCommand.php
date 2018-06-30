<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\Command\Projections;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RunProjectionCommand extends ProjectionCommand {

    protected function configure() {
        $this->setName('sourcekin:projection:run')
             ->addArgument('projection', InputArgument::REQUIRED)
            ->addOption('once', '', InputOption::VALUE_NONE)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $io = new SymfonyStyle($input, $output);

        $projector = $this->initializeProjector($input);
        $runOnce = $input->getOption('once');

        $io->writeln(sprintf('running <info>%s</info>', $input->getArgument('projection')));
        $io->writeln(sprintf('Run Once is <info>%s</info>', $runOnce ? 'ON': 'OFF'));
        $projector->run(! $runOnce);

    }


}