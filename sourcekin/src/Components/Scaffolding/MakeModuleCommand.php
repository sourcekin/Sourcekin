<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Components\Scaffolding;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeModuleCommand extends Command
{
    protected function configure()
    {
        $this->setName('make:module')
            ->addArgument('name', InputArgument::REQUIRED)
            ->addArgument('stream', InputArgument::REQUIRED)
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $maker = new ModuleMaker();
        $maker->generateScaffold($input->getArgument('name'), $input->getArgument('stream'));

        $io->success('Module done.');
    }

}