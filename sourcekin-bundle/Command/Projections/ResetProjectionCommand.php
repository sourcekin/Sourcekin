<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 29.06.18.
 */

namespace SourcekinBundle\Command\Projections;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ResetProjectionCommand extends ProjectionCommand {

    protected function configure() {
        $this->setName('sourcekin:projection:reset')
             ->addArgument('projection', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $io = new SymfonyStyle($input, $output);

        $projector = $this->initializeProjector($input);
        $projector->reset();

    }
}