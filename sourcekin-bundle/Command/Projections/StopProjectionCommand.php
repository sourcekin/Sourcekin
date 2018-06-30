<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 30.06.18.
 */

namespace SourcekinBundle\Command\Projections;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StopProjectionCommand extends ProjectionCommand {
    protected function configure() {

        $this->setName('sourcekin:projection:stop')
             ->addArgument('projection', InputArgument::REQUIRED)
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->manager->stopProjection($input->getArgument('projection'));

    }


}