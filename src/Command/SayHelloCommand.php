<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 06.06.18
 *
 */

namespace App\Command;


use Sourcekin\Domain\Command\HelloCommand;
use Sourcekin\Domain\Message\BusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SayHelloCommand extends Command
{

    /**
     * @var BusInterface
     */
    protected $bus;

    /**
     * SayHelloCommand constructor.
     *
     * @param BusInterface $bus
     */
    public function __construct(BusInterface $bus) {
        $this->bus = $bus;
        parent::__construct();
    }


    protected function configure()
    {
        $this->setName('say:hello');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bus->dispatch(new HelloCommand());
    }

}